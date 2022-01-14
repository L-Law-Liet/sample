Dropzone.prototype.defaultOptions.dictRemoveFile = "Remove";
let isFirst = true;
let dropzone = null;
function loadDropzone(){

    if (isFirst){
        dropzone = new Dropzone("#dropzone", {
            url: "/products/upload/image",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            maxFileSize: 12000000,
            acceptedFiles: 'image/*',
            // uploadMultiple: true,
            addRemoveLinks: true,
            maxFiles: 10,
            parallelUploads: 10,
            renameFile: function (file){
                let time = new Date().getTime();
                return time + file.name;
            },
            init: function () {
                this.on("success", function (file, response) {
                    dropzone.files = dropzone.files.filter(function( obj ) {
                        return obj.status !== "error";
                    });
                    console.log(dropzone.files);
                    Livewire.emit('imageUpdated', JSON.stringify(dropzone.files));
                });
                this.on("error", function (file, response) {
                    dropzone.files = dropzone.files.filter(function( obj ) {
                        return obj.status !== "error";
                    });
                    file.previewElement.remove();
                });
                this.on("reset", function () {
                    document.getElementById('dropzone').innerText = 'Upload your images';
                });
                this.on("processing", function(file){
                    $('#dropzone').contents().filter(function(){
                        return this.nodeType != 1;
                    }).remove();
                    file.previewElement.addEventListener("click", function() {
                        this.removeFile(file);
                    });
                });
            },
            removedfile: function(file) {
                Livewire.emit('imageUpdated', JSON.stringify(dropzone.files));
                file.previewElement.remove();
            },
        });
        isFirst = false;
    }
}

function deleteFile(uuid) {
    dropzone.files = dropzone.files.filter(function( obj ) {
        return obj.upload.uuid !== uuid;
    });
}
