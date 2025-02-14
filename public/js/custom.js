/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
$(document).ready(function () {
    $('#checkSize').on('click', function (e) {
        e.preventDefault();
        var deskripsi = $('#deskripsi').val();
        var regex = /<img[^>]+src=["']([^"']+)["']/g;
        var matches, base64Str, totalFileSize = 0, countFile = 0;

        while (matches = regex.exec(deskripsi)) {
            var imgSrc = matches[1];
            if (imgSrc.startsWith('data:image')) {
                base64Str = imgSrc.split(',')[1];
                var fileSize = getBase64FileSize(base64Str);
                if (totalFileSize < fileSize) {
                    totalFileSize = fileSize;
                }
                // totalFileSize += fileSize;
                countFile++;
                // $('#fileSize').append('Ukuran file: ' + fileSize.toFixed(1) + ' MB<br>');
            }
        }

        if (countFile > 0) {
            var avgFileSize = totalFileSize;
            // var avgFileSize = totalFileSize / countFile;
            if (avgFileSize <= 2) {
                $('#fileForm').submit();
            } else {
                if (countFile > 1) {
                    showWarningAlert('Ada file foto/gambar yang terlalu besar ' + avgFileSize.toFixed(1) + ' MB, max. 2 MB');
                } else {
                    showWarningAlert('File foto/gambar terlalu besar ' + avgFileSize.toFixed(1) + ' MB, max. 2 MB');
                }
            }
        } else {
            $('#fileForm').submit();
        }
    });

    function getBase64FileSize(base64Str) {
        var padding, inBytes, base64StringLength;
        if (base64Str.endsWith('==')) {
            padding = 2;
        } else if (base64Str.endsWith('=')) {
            padding = 1;
        } else {
            padding = 0;
        }
        base64StringLength = base64Str.length;
        inBytes = (base64StringLength / 4) * 3 - padding;
        return (inBytes / (1000 * 1000));
    }
});
$(document).on("change", "#image-upload", function (e) {
    e.preventDefault()
    let jmlFiles = $("#image-upload")[0].files
    let maxSize = 2
    let totFiles = jmlFiles[0].size
    // let totFiles = 0
    // $.each(jmlFiles, function(index, val) {
    //     totFiles += val.size
    // })
    let filesize = totFiles / 1000 / 1000;
    filesize = filesize.toFixed(1);
    if (filesize > maxSize) {
        showWarningAlert('File foto max. ' + maxSize + ' MB, Total size : ' + filesize + ' MB')
        $("#image-upload").val('')
        $('#checkSize').prop('disabled', true);
    } else {
        $('#checkSize').prop('disabled', false);
    }
});
$(document).on("change", "#file-upload", function (e) {
    e.preventDefault()
    let jmlFiles = $("#file-upload")[0].files
    let maxSize = 4
    let totFiles = jmlFiles[0].size
    let filesize = totFiles / 1000 / 1000;
    filesize = filesize.toFixed(1);
    if (filesize > maxSize) {
        showWarningAlert('File upload max. ' + maxSize + ' MB, Total size : ' + filesize + ' MB')
        $("#image-upload").val('')
        $('#checkSize').prop('disabled', true);
    } else {
        $('#checkSize').prop('disabled', false);
    }
});