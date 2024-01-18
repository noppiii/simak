$('.file-uploader').on('dragover dragenter', function (e) {
    e.preventDefault();
    $(this).addClass('is-dragover');
}).on('dragleave dragend drop', function () {
    $(this).removeClass('is-dragover');
});

$(function () {
    var dropzoneCounter = 0;

    $('.file-uploader').on('dragenter', function () {
        dropzoneCounter++;
        var $this = $(this);
        $this.addClass('is-dragover');
    });

    $('.file-uploader').bind('dragleave', function () {
        dropzoneCounter--;
        if (dropzoneCounter === 0) {
            $(this).removeClass('is-dragover');
        }
    });

    $('.file-uploader').bind('drop', function (e) {
        e.preventDefault();
        dropzoneCounter = 0;
        $(this).removeClass('is-dragover');
        handleFiles(e.originalEvent.dataTransfer.files, $(this));
    });

    $('#fileInput').on('change', function () {
        handleFiles(this.files, $('.file-uploader'));
    });

    function handleFiles(files, $uploader) {
        var $fileList = $uploader.find('#fileList');
        $fileList.empty();
        for (var i = 0; i < files.length; i++) {
            $fileList.append('<li>' + files[i].name + '</li>');
        }
        // Perform additional logic with the files
        // For example, you can trigger an AJAX request to upload the files.
    }
});
