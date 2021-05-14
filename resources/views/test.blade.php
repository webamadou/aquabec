<!DOCTYPE html><!--
	Copyright (c) 2014-2021, CKSource - Frederico Knabben. All rights reserved.
	This file is licensed under the terms of the MIT License (see LICENSE.md).
-->

<html lang="en" dir="ltr"></html>
<head>
	<title>CKEditor 5 ClassicEditor build</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="https://c.cksource.com/a/1/logos/ckeditor5.png">
	<link rel="stylesheet" type="text/css" href="{{asset('dist/ckeditor5/styles.css')}}">
</head>
<body data-editor="ClassicEditor" data-collaboration="false">
	<header>
		<div class="centered">
			<h1><a href="https://ckeditor.com/ckeditor-5/" target="_blank" rel="noopener noreferrer"><img src="https://c.cksource.com/a/1/logos/ckeditor5.svg" alt="CKEditor 5 logo">CKEditor 5</a></h1>
			<nav>
				<ul>
					<li><a href="https://ckeditor.com/docs/ckeditor5/" target="_blank" rel="noopener noreferrer">Documentation</a></li>
					<li><a href="https://ckeditor.com/" target="_blank" rel="noopener noreferrer">Website</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<main>
		<div class="message">
			<div class="centered">
				<h2>CKEditor 5 online builder demo - ClassicEditor build</h2>
			</div>
		</div>
		<div class="centered">
			<div class="row row-editor">
				<textarea name="editor" id="editor" class="editor" cols="30" rows="100"></textarea>
			</div></div>
		</div>
	</main>
	<footer>
		<p><a href="https://ckeditor.com/ckeditor-5/" target="_blank" rel="noopener">CKEditor 5</a>
			– Rich text editor of tomorrow, available today
		</p>
		<p>Copyright © 2003-2021,
			<a href="https://cksource.com/" target="_blank" rel="noopener">CKSource</a>
			– Frederico Knabben. All rights reserved.
		</p>
	</footer>
	<script src="{{asset('dist/ckeditor5/build/ckeditor.js')}}"></script>
	<script>ClassicEditor
			.create( document.querySelector( '.editor' ), {
				
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
						'link',
						'bulletedList',
						'numberedList',
						'|',
						'outdent',
						'indent',
						'|',
						'imageUpload',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'undo',
						'redo',
						'CKFinder',
						'underline',
						'fontColor',
						'removeFormat',
						'alignment'
					]
				},
				language: 'fr',
				image: {
					toolbar: [
						'imageTextAlternative',
						'imageStyle:full',
						'imageStyle:side'
					]
				},
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells'
					]
				},
				licenseKey: '',
				
				
			} )
			.then( editor => {
				window.editor = editor;
			} )
			.catch( error => {
				console.error( 'Oops, something went wrong!' );
				console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
				console.warn( 'Build id: qp877ojrkize-b9d1q6l02xnr' );
				console.error( error );
			} );
	</script>
</body>