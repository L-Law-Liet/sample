<?php

namespace App\Http\Livewire\Products;

use App\Models\Client;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Modules\Category\Facades\CategoriesFacade;
use App\Modules\Client\Facades\ClientsFacade;
use App\Modules\Problem\Facades\ProblemTypesFacade;
use App\Modules\Product\Facades\CommentsFacade;
use App\Modules\Product\Facades\ProductsFacade;
use App\Modules\Product\Requests\StoreProductRequest;
use App\Modules\Product\Requests\UpdateProductRequest;
use App\Modules\Status\Facades\StatusesFacade;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

    public int $internal = Client::UNKNOWN;
    public int $client_id = 0;
    public int $category_id = 0;
    public int $problem_type_id = 0;
    public int $product_status_id = ProductStatus::FOR_REPAIR;

    public string $location = '';
    public $reported_by = '';
    public string $serial = '';
    public array $images = [];
    public string $description = '';
    public string $parts = '';
    public string $comment = '';

    public $clients = [];
    public $categories = [];
    public $statuses = [];
    public $problems = [];
    public $comments = [];

    //Edit
    public ?Product $product = null;

    protected $listeners = ['problemAdded', 'clientAdded', 'categoryAdded', 'imageUpdated'];

    public function mount()
    {
        if ($this->product) {
            foreach ((array)json_decode($this->product->images) as $image) {
                $this->images[] = $image;
            }
            $this->reported_by = $this->product->reported_by;
            $this->serial = $this->product->serial;
            $this->internal = $this->product->client->internal;
            $this->description = $this->product->description;
            $this->location = $this->product->location;
            $this->parts = $this->product->parts;
        }
        $this->setAll();
    }

    public function problemAdded()
    {
        $this->setProblems();
    }

    public function clientAdded()
    {
        $this->setClients();
    }

    public function categoryAdded()
    {
        $this->setCategories();
    }

    /**
     * @return \string[][]
     */
    protected function rules(): array
    {
        ($this->product)
            ? $rules = (new UpdateProductRequest)->rules()
            : $rules = (new StoreProductRequest)->rules();

        $excepts = [];
        if ($this->internal == 0) {
            $excepts[] = 'reported_by';
        }
        return Arr::except($rules, $excepts);
    }

    /**
     * @var array|string[]
     */
    protected array $validationAttributes = [
        'client_id' => 'client',
        'category_id' => 'category',
        'product_status_id' => 'status',
        'problem_type_id' => 'problem type',
    ];

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = $this->validate();
        $product = $this->getProductsFacade()->create($data);
        $this->comment = trim($this->comment);
        if ($this->comment)
            $this->storeComment($product->id);
        return redirect()->route('products.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $data = $this->validate();
        $comments = $data['comments'];
        unset($data['comments']);

        $this->getProductsFacade()->update($this->product, $data);

        foreach ($comments as $comment) {
            if ($comment['user_id'] == auth()->id()) {
                $this->getCommentsFacade()->update(['body' => $comment['body']], $comment['id']);
            }
        }

        $this->comment = trim($this->comment);
        if ($this->comment)
            $this->storeComment($this->product->id);

        return redirect()->route('products.index');
    }

    public function storeComment($id)
    {
        if (strlen($this->comment) < 1000) {
            $data = [
                'body' => $this->comment,
                'user_id' => auth()->id(),
                'product_id' => $id,
            ];
            $this->getCommentsFacade()->create($data);
        }
    }

    public function render()
    {
        $this->dispatchBrowserEvent('loaded');
        return view('livewire.products.add');
    }

    public function setProblems()
    {
        $this->problems = $this->getProblemTypesFacade()->getAll()->pluck('name', 'id');
        if ($this->product)
             $this->problem_type_id = $this->product->problem_type_id;
    }

    public function setCategories()
    {
        $this->categories = $this->getCategoriesFacade()->getAll()->pluck('name', 'id');
        if ($this->product)
            $this->category_id = $this->product->category_id;
    }

    public function setComments()
    {
        if ($this->product) {
            $this->comments = $this->getCommentsFacade()->getByProductId($this->product->id)->toArray();
        }
    }

    public function setStatuses()
    {
        $this->statuses = $this->getStatusesFacade()->getAll()->pluck('name', 'id');
        if ($this->product)
            $this->product_status_id = $this->product->product_status_id;
    }

    public function setClients()
    {
        ($this->internal == 1)
            ? $this->clients = $this->getClientsFacade()->getInternals()->pluck('name', 'id')
            : $this->clients = $this->getClientsFacade()->getExternals()->pluck('name', 'id');
        if ($this->product)
            $this->client_id = $this->product->client_id;

    }

    public function setAll()
    {
        $this->setCategories();
        $this->setClients();
        $this->setProblems();
        $this->setStatuses();
        $this->setComments();
    }

    /**
     * @return ProductsFacade
     */
    public function getProductsFacade(): ProductsFacade
    {
        return resolve(ProductsFacade::class);
    }

    /**
     * @return ClientsFacade
     */
    public function getClientsFacade(): ClientsFacade
    {
        return resolve(ClientsFacade::class);
    }

    /**
     * @return CategoriesFacade
     */
    public function getCategoriesFacade(): CategoriesFacade
    {
        return resolve(CategoriesFacade::class);
    }

    /**
     * @return StatusesFacade
     */
    public function getStatusesFacade(): StatusesFacade
    {
        return resolve(StatusesFacade::class);
    }

    /**
     * @return ProblemTypesFacade
     */
    public function getProblemTypesFacade(): ProblemTypesFacade
    {
        return resolve(ProblemTypesFacade::class);
    }

    /**
     * @return CommentsFacade
     */
    public function getCommentsFacade(): CommentsFacade
    {
        return resolve(CommentsFacade::class);
    }

    public function updatedInternal()
    {
        if ($this->product) {
            $this->internal = $this->product->client->internal;
        }
        $this->setClients();
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        foreach ($this->comments as $comment) {
            if ($comment['id'] == $id) {
                $this->getCommentsFacade()->delete($id);
                $this->setComments();
                break;
            }
        }
    }

    public function imageUpdated($files)
    {
        foreach (json_decode($files) ?? [] as $file) {
            $this->images[$file->upload->uuid] = '/products/images/' . $file->upload->filename;
        }
    }

    public function deleteImage(string $i)
    {
        unset($this->images[$i]);
    }
}
