/*! file Uploader - v1.0.0 - 15/07/2019
 * Copyright (c) 2019 Christian Bayer; Licensed MIT */

(function ($) {

    $.fn.fileUploader = function (options) {

        // Default settings
        let defaults = {
            preloaded: [],
            filesInputName: 'files',
            preloadedInputName: 'preloaded',
            label: 'Drag & Drop files here or click to browse'
        };

        // Get instance
        let plugin = this;

        // Set empty settings
        plugin.settings = {};

        // Plugin constructor
        plugin.init = function () {

            // Define settings
            plugin.settings = $.extend(plugin.settings, defaults, options);

            // Run through the elements
            plugin.each(function (i, wrapper) {

                // Create the container
                let $container = createContainer();

                // Append the container to the wrapper
                $(wrapper).append($container);

                // Set some bindings
                $container.on("dragover", fileDragHover.bind($container));
                $container.on("dragleave", fileDragHover.bind($container));
                $container.on("drop", fileSelectHandler.bind($container));

                // If there are preloaded files
                if (plugin.settings.preloaded.length) {

                    // Change style
                    $container.addClass('has-files');

                    // Get the upload files container
                    let $uploadedContainer = $container.find('.uploaded');

                    // Set preloaded files preview
                    for (let i = 0; i < plugin.settings.preloaded.length; i++) {
                        $uploadedContainer.append(createImg(plugin.settings.preloaded[i].src, plugin.settings.preloaded[i].id, true));
                    }

                }

            });

        };


        let dataTransfer = new DataTransfer();

        let createContainer = function () {

            // Create the file uploader container
            let $container = $('<div>', {class: 'file-uploader'}),

                // Create the input type file and append it to the container
                $input = $('<input>', {
                    type: 'file',
                    id: plugin.settings.filesInputName + '-' + random(),
                    name: plugin.settings.filesInputName + '[]',
                    multiple: ''
                }).appendTo($container),

                // Create the uploaded files container and append it to the container
                $uploadedContainer = $('<div>', {class: 'uploaded row', style: 'margin-right: 10px; margin-left: 10px;'}).appendTo($container),

                // Create the text container and append it to the container
                $textContainer = $('<div>', {
                    class: 'upload-text'
                }).appendTo($container),

                // Create the icon and append it to the text container
                $i = $('<i>', {class: 'material-icons', text: 'Upload Files'}).appendTo($textContainer),

                // Create the text and append it to the text container
                $span = $('<span>', {text: plugin.settings.label}).appendTo($textContainer);


            // Listen to container click and trigger input file click
            $container.on('click', function (e) {
                // Prevent browser default event and stop propagation
                prevent(e);

                // Trigger input click
                $input.trigger('click');
            });

            // Stop propagation on input click
            $input.on("click", function (e) {
                e.stopPropagation();
            });

            // Listen to input files changed
            $input.on('change', fileSelectHandler.bind($container));

            return $container;
        };


        let prevent = function (e) {
            // Prevent browser default event and stop propagation
            e.preventDefault();
            e.stopPropagation();
        };

        let createImg = function (src, id, files) {
// console.log('id : '+id);
// console.log('files : '+files);
//     var fileNameIndex = id.lastIndexOf("/") + 1;
//     var filename = id.substr(fileNameIndex);
// console.log('files : '+filename);

            // Create the upladed file container
            let $container = $('<div>', {class: 'uploaded-file col-lg-12 row mb-1', style: 'height: 2rem;'}),

                // Create the img tag
                // $img = $('<img>', {src: src, class: 'view-file'}).appendTo($container),
                $detail_contain = $('<div>', {class: 'col-lg-1', style: 'height: 2rem; padding: 3px;'}).appendTo($container),
                $img = $('<img>', {src: '../../argon/img/icons/file_icon.ico'}).appendTo($detail_contain),

                $detail_contain2 = $('<div>', {class: 'col-lg-11', style: 'height: 2rem; max-width: 25rem;'}).appendTo($container),
                $lable = $('<p>', {text: files.name, style: 'overflow: hidden;'}).appendTo($detail_contain2),

                // Create the delete button
                $button = $('<button>', {class: 'delete-file'}).appendTo($container),

                // Create the delete icon
                $i = $('<i>', {class: 'fas fa-times'}).appendTo($button);

                // Create the download button
                $download = $('<button>', {class: 'download-file'}).appendTo($container),
                // Create the delete icon
                $iDwn = $('<i>', {class: 'fas fa-download'}).appendTo($download);

            // If the files are preloaded
            if (plugin.settings.preloaded.length) {

                // Set a identifier
                $container.attr('data-preloaded', true);

                // Create the preloaded input and append it to the container
                let $preloaded = $('<input>', {
                    type: 'hidden',
                    name: plugin.settings.preloadedInputName + '[]',
                    value: id
                }).appendTo($container)

            } else {

                // Set the identifier
                $container.attr('data-index', id);

            }

            // Stop propagation on click
            $container.on("click", function (e) {
                // Prevent browser default event and stop propagation
                prevent(e);
            });

            // Set delete action
            $button.on("click", function (e) {
                // Prevent browser default event and stop propagation
                prevent(e);

                // If is not a preloaded file
                if ($container.data('index')) {

                    // Get the file index
                    let index = parseInt($container.data('index'));

                    // Update other indexes
                    $container.find('.uploaded-file[data-index]').each(function (i, cont) {
                        if (i > index) {
                            $(cont).attr('data-index', i - 1);
                        }
                    });

                    // Remove the file from input
                    dataTransfer.items.remove(index);
                }

                // Remove this file from the container
                $container.remove();

                // If there is no more uploaded files
                if (!$container.find('.uploaded-file').length) {
                    // Remove the 'has-files' class
                    $container.find('.uploaded-file').removeClass('has-files');

                }

            });

            // $img.on("click", function (e){
            //     console.log('works');
            // });

            return $container;
        };

        let fileDragHover = function (e) {

            // Prevent browser default event and stop propagation
            prevent(e);

            // Change the container style
            if (e.type === "dragover") {
                $(this).addClass('drag-over');
            } else {
                $(this).removeClass('drag-over');
            }
        };

        let fileSelectHandler = function (e) {

            // Prevent browser default event and stop propagation
            prevent(e);

            // Get the jQuery element instance
            let $container = $(this);

            // Change the container style
            $container.removeClass('drag-over');

            // Get the files
            let files = e.target.files || e.originalEvent.dataTransfer.files;

            // Makes the upload
            if(files.length > 0){
                setPreview($container, files);
            }
        };

        let setPreview = function ($container, files) {

            // Add the 'has-files' class
            $container.addClass('has-files');

            // Get the upload files container
            let $uploadedContainer = $container.find('.uploaded'),

                // Get the files input
                $input = $container.find('input[type="file"]');

            // Run through the files
            $(files).each(function (i, file) {

                // Add it to data transfer
                dataTransfer.items.add(file);

                // Set preview
                $uploadedContainer.append(createImg(URL.createObjectURL(file), dataTransfer.items.length - 1, file));

            });

            // Update input files
            $input.prop('files', dataTransfer.files);

        };

        // Generate a random id
        let random = function () {
            return Date.now() + Math.floor((Math.random() * 100) + 1);
        };

        this.init();

        // Return the instance
        return this;
    };

}(jQuery));
