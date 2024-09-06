$(document).ready(function(){
    "use strict";
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table_name = $('#table_name').val();
    var recordId = $('#record_id').val();

    // Function to escape special characters in file names for use in IDs
    function escapeFileName(fileName) {
        return fileName.replace(/[ .\-()]/g, '_');
    }

    // Function to load files
    // patientId,procedure_id,teethNumber,table
    window.loadFiles = function(recordId) { // Attach to window object
        if (!recordId) {
            console.error('Record ID is missing. Cannot load files.');
            return;
        }

        $.ajax({
            url: getFilesUrl,
            type: 'GET',
            data: { table_name: table_name },
            success: function(response) {
                // Clear existing file tables
                $('.fileTableBody').html('');

                // Iterate through response to populate files dynamically
                if (response.files) {
                    $.each(response.files, function(recordType, files) {
                        // Convert recordType to camelCase to match HTML IDs
                        var tableBodyId = '#' + recordType.replace(/_(.)/g, (match, p1) => p1.toUpperCase()) + 'TableBody';

                        // Check if the table body exists in the DOM
                        if ($(tableBodyId).length > 0) {
                            files.forEach(file => {
                                var filePath = baseUrl + 'storage/uploads/' + table_name + '/' + recordId + '/' + recordType + '/' + file.file_name;
                                $(tableBodyId).append(
                                    `<tr id="file-row-${recordType}-${escapeFileName(file.file_name)}">
                                        <td>${file.file_name}</td>
                                        <td>${file.uploaded_by}</td>
                                        <td>${file.uploaded_at}</td>
                                        <td>
                                            <span class="btn btn-info">
                                                <a style="color:#fff" href="${filePath}" download><i class="fas fa-download"></i></a>
                                            </span>
                                            <span onclick="confirmDeleteFile('${file.file_name}', '${recordType}', '${recordId}', '${tableBodyId.substring(1)}')" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </span>
                                        </td>
                                    </tr>`
                                );
                            });

                            // If no files, display a message
                            if (files.length === 0) {
                                $(tableBodyId).append('<tr><td colspan="4">@lang(No files found.)</td></tr>');
                            }
                        } else {
                            console.error('Table Body not found for:', tableBodyId);
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                alert('Error loading files: ' + error);
            }
        });
    }

    // Call loadFiles when the page loads
    if ($('.fileTableBody').length > 0) {
        var initialRecordId = $('#record_id').val();
        loadFiles(initialRecordId);
    }
    // Handle file upload
    $(document).on('change', 'input[type="file"]', function() {
    var inputId = $(this).attr('id'); //profile_picture
    var toothNumber = $('#tooth_number').val(); // Get tooth number from modal ..
    var examinationId = $('#examination_id').val(); // Get tooth number from modal ..
    var table_name = $('#table_name').val(); // Hidden input field for module name //patient
    var recordId = $('#record_id').val(); // Hidden input field for record ID //id
    var Childtable = $('#child_table').val(); // Hidden input field for record ID ..
    var formData = new FormData();
    var files = $(this)[0].files;

    for (var i = 0; i < files.length; i++) {
        formData.append(inputId + '[]', files[i]);
    }

    formData.append('table_name', table_name);
    formData.append('record_id', recordId);
    formData.append('input_fields[]', inputId);
    formData.append('toothNumber', toothNumber);
    formData.append('examinationId', examinationId);
    formData.append('Childtable', Childtable);

    $.ajax({
        url: uploadFilesUrl,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Reload files after successful upload
                if (inputId === 'teeth_files') {
                    window.getFiles(); // Call getfiles for teeth_files
                } else {
                    loadFiles(recordId); // Call loadFiles for other files
                } // This calls the globally defined getfiles function


            } else {
                alert('Error uploading files: ' + response.errors.join(', '));
            }
        },
        error: function(xhr, status, error) {
            alert('Error uploading files: ' + error);
        }
    });
    });

    window.confirmDeleteFile = function(fileName, fileType, recordId, tableBodyId) {
        if (confirm('Are you sure you want to delete this file?')) {
            deleteFile(fileName, fileType, recordId, table_name,tableBodyId);
        }
    };

    // Function to delete file
    window.deleteFile = function(fileName, fileType, recordId, table_name, tableBodyId) {
    console.log('Deleting file:', fileName, 'of type:', fileType, 'for record ID:', recordId, 'in table:', table_name);

    $.ajax({
        url: deleteFilesUrl,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            fileName: fileName,
            fileType: fileType,
            recordId: recordId,
            table_name: table_name
        },
        success: function(response) {
            if (response.success) {
                var escapedFileName = escapeFileName(fileName);
                $(`#${tableBodyId}`).find(`#file-row-${fileType}-${escapedFileName}`).remove(); // Adjusted selector
            } else {
                alert('Error deleting file: ' + response.error);
            }
        },
        error: function(xhr, status, error) {
            alert('Error deleting file: ' + error);
        }
    });
};

$('form').on('submit', function (event) {
    var form = $(this);

    // Reset any previously added validation classes
    form.removeClass('was-validated');

    // Check if the form is valid according to browser's built-in validation
    if (form[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        form.addClass('was-validated');
    } else {
        // Perform any custom JS validation (e.g., Parsley.js)
        if (form.parsley().isValid()) {
            // If the form is valid, disable the submit button
            form.find('button[type="submit"], input[type="submit"]').prop('disabled', true);
        } else {
            // Prevent form submission if custom validation fails
            event.preventDefault();
            event.stopPropagation();
        }
    }

    // Add Bootstrap's validation styles (if using Bootstrap)
    form.addClass('was-validated');
});

});
