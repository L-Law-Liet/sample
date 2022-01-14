<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Modules\Product\Facades\CommentsFacade;
use App\Modules\Product\Facades\ProductsFacade;
use App\Modules\Product\Requests\CommentsRequest;
use App\Modules\Status\Facades\StatusesFacade;
use Livewire\Component;
use function PHPUnit\Framework\returnArgument;

class View extends Component
{
    public Product $product;

    public array $statuses = [];
    public $comments = [];

    public int $product_status_id;
    public string $comment = '';

    public function mount()
    {
        $this->product_status_id = $this->product->product_status_id;
        $this->setStatuses();
        $this->setComments();
    }


    /**
     * @return \string[][]
     */
    protected function rules(): array
    {
        return (new CommentsRequest)->rules();
    }

    protected array $validationAttributes = [
        'comments.*.body' => 'comment',
    ];

    public function store()
    {
        $data = $this->validate();
        $comments = $data['comments'];
        if ($this->comment && strlen($this->comment) < 1000){
            $data = [
                'body' => $this->comment,
                'user_id' => auth()->id(),
                'product_id' => $this->product->id,
            ];
            $this->getCommentsFacade()->create($data);
        }
        foreach ($comments as $comment){
            if ($comment['user_id'] == auth()->id()){
                $this->getCommentsFacade()->update(['body' => $comment['body']], $comment['id']);
            }
        }
        $this->setComments();
        $this->comment = '';
    }

    public function claim()
    {
        $this->getProductsFacade()->claim($this->product->id);
    }

    public function getProductsFacade(): ProductsFacade
    {
        return resolve(ProductsFacade::class);
    }

    /**
     * @return StatusesFacade
     */
    public function getStatusesFacade(): StatusesFacade
    {
        return resolve(StatusesFacade::class);
    }

    public function setStatuses()
    {
        $this->statuses = $this->getStatusesFacade()->getAll()->pluck('name', 'id')->toArray();
    }

    public function updatedProductStatusId()
    {
        $this->getProductsFacade()->updateStatus($this->product->id, $this->product_status_id);
    }
    public function setComments()
    {
        $this->comments = $this->getCommentsFacade()->getByProductId($this->product->id)->toArray();

    }

    /**
     * @return CommentsFacade
     */
    public function getCommentsFacade(): CommentsFacade
    {
        return resolve(CommentsFacade::class);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        foreach ($this->comments as $comment){
            if ($comment['id'] == $id){
                $this->getCommentsFacade()->delete($id);
                $this->setComments();
                break;
            }
        }
    }
    public function render()
    {
        $this->product = $this->getProductsFacade()->findOrFail($this->product->id);
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.products.view');
    }
}
