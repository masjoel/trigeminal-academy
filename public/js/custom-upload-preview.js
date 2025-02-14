(function ($) {
    $.extend({
        uploadPreview: function (options) {
            // Options + Defaults
            var settings = $.extend(
                {
                    image_tampil: ".image-tampil-2",
                    input_field: ".image-input-2",
                    preview_box: ".image-preview-2",
                    label_field: ".image-label",
                    label_default: "Choose File",
                    label_selected: "Change File",
                    no_label: false,
                },
                options
            );

            // Check if FileReader is available
            if (window.File && window.FileList && window.FileReader) {
                if (
                    typeof $(settings.input_field) !== "undefined" &&
                    $(settings.input_field) !== null
                ) {
                    $(settings.input_field).change(function () {
                        var files = this.files;

                        if (files.length > 0) {
                            var file = files[0];
                            var reader = new FileReader();

                            // Load file
                            reader.addEventListener("load", function (event) {
                                var loadedFile = event.target;

                                // Check format
                                if (file.type.match("image")) {
                                    // Image
                                    $(settings.image_tampil).css(
                                        "display",
                                        "none"
                                    );
                                    $(settings.preview_box).css(
                                        "background-image",
                                        "url(" + loadedFile.result + ")"
                                    );
                                    $(settings.preview_box).css(
                                        "background-size",
                                        "cover"
                                    );
                                    $(settings.preview_box).css(
                                        "background-position",
                                        "center center"
                                    );
                                } else if (file.type.match("audio")) {
                                    // Audio
                                    $(settings.preview_box).html(
                                        "<audio controls><source src='" +
                                        loadedFile.result +
                                        "' type='" +
                                        file.type +
                                        "' />Your browser does not support the audio element.</audio>"
                                    );
                                } else {
                                    // alert("This file type is not supported yet.");
                                    swal("Oops", "Tipe file tidak support", "error");
                                }
                            });

                            if (settings.no_label == false) {
                                // Change label
                                $(settings.label_field).html(
                                    settings.label_selected
                                );
                            }

                            // Read the file
                            reader.readAsDataURL(file);
                        } else {
                            if (settings.no_label == false) {
                                // Change label
                                $(settings.label_field).html(
                                    settings.label_default
                                );
                            }

                            // Clear background
                            $(settings.preview_box).css(
                                "background-image",
                                "none"
                            );

                            // Remove Audio
                            $(settings.preview_box + " audio").remove();
                        }
                    });
                }
            } else {
                // alert("You need a browser with file reader support, to use this form properly.");
                swal("Oops", "Diperlukan browser yang support file reader", "error");
                return false;
            }
        },
    });
})(jQuery);

const imageUploads = [
    { input_field: "#image-upload-1", preview_box: "#image-preview-1", label_field: "#image-label-1" },
    { input_field: "#image-upload-2", preview_box: "#image-preview-2", label_field: "#image-label-2" },
    { input_field: "#image-upload-3", preview_box: "#image-preview-3", label_field: "#image-label-3" },
    { input_field: "#image-upload-4", preview_box: "#image-preview-4", label_field: "#image-label-4" },
    { input_field: "#image-upload-5", preview_box: "#image-preview-5", label_field: "#image-label-5" },
];

imageUploads.forEach(function (upload) {
    $.uploadPreview({
        input_field: upload.input_field,
        preview_box: upload.preview_box,
        label_field: upload.label_field,
        label_default: "Choose File",
        label_selected: "Change File",
        no_label: false,
        success_callback: null
    });
});

$(".inputtags").tagsinput('items');
