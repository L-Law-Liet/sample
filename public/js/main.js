let sortBy = null;
function loading(){
    document.getElementById('loader').style.display = 'flex';
}
document.addEventListener('loaded', function (){
    $('.select2').select2();
    document.getElementById('loader').style.display = 'none';
});
document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2();
});
$('#filterSlideToggle').click(function (){
    $( "#filtersDiv" ).slideToggle();
});
function validateDate(event) {
    if (!event.target.value){
        event.target.value = '';
    }
}
$('.filters').change(setUrl);

function getFilters(){
    return {
        'idx': $('#idx').val(),
        'productStatusId': $('#productStatusId').val(),
        'categoryId': $('#categoryId').val(),
        'problemTypeId': $('#problemTypeId').val(),
        'clientId': $('#clientId').val(),
        'name': $('#name').val(),
        'email': $('#email').val(),
        'phone': $('#phone').val(),
        'address': $('#address').val(),
        'type': $('#type').val(),
        'payoutStart': $('#payoutStart').val(),
        'description': $('#description').val(),
        'payoutEnd': $('#payoutEnd').val(),
        'dateStart': $('#dateStart').val(),
        'dateEnd': $('#dateEnd').val(),
        'status': $('#status').val(),
        'range': $('#range').val(),
        'technician': $('#technician').val(),
        'audited': $('#audited').val(),
    };
}

function setUrl(){
    const filters = getFilters();
    let getParams = '?';
    for (const key in filters) {
        const val = filters[key];
        if (val){
            getParams += key + '=' + val + '&';
        }
    }
    if (sortBy){
        getParams += 'sortBy=' + encodeURIComponent(JSON.stringify(sortBy));
    }
    window.history.replaceState(null, null, getParams );
}

document.addEventListener('livewire:sorted', function (param){
    sortBy = param.detail;
    setUrl();
});
document.addEventListener('livewire:reset-filters', function (){
    setUrl();
});
$('button.page-link').click(loading);
