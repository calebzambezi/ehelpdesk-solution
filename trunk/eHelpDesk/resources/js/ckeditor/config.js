/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	//config.uiColor = '#AADC6E';
	//config.language ='en'; *** Implemented programmatically
	//config.enterMode = CKEDITOR.ENTER_BR; *** 1. this makes <br /> is the element repsonsible for new lines (NOT NEEDED ANYMORE). <p> is preferred. Read the line below.
	//config.contentsCss = 'p{padding: 0; margin: 0;}'; //2. When user press Enter key, <p> is created by default instead of <br />. As known, <p> creates double space by default. Therefore, i added a css snippet to set p element of ckeditor to zero values. As a result, new lines will appear in single space rather than double space. config.contentsCss = 'xxxxHERExxxxx'; xxxxHERExxxx could be any css that would be applied to the ckeditor, e.g. p{padding: 0; margin: 0;}, this css snippet will allow the single space rather than the default double space. However, whatever css you put in here will replace the default styles in "ckeditor/contents.css" file. Therefore, i commented this line out and put p{padding: 0; margin: 0;} in the default css file contents.css. Alternaticely, in xxxxHERExxxx you can put a path to your own custom css file, which will be applied to ckeditor, by doing so, your custom css will take place instead of contents.css
	config.removePlugins = 'elementspath'; //removes elements representation, e.g. "p body ul", at bottom of the editor interface.
	config.resize_minWidth = 688;
	config.resize_maxWidth = 688;
	config.width = 688;
	config.resize_minHeight = 700;
	config.smiley_images = [
    'regular_smile.gif','sad_smile.gif','wink_smile.gif','teeth_smile.gif','confused_smile.gif','tounge_smile.gif',
    'embaressed_smile.gif','omg_smile.gif','whatchutalkingabout_smile.gif','angry_smile.gif','shades_smile.gif',
	'cry_smile.gif','lightbulb.gif','thumbs_down.gif','thumbs_up.gif','envelope.gif'
	];

	config.toolbar_basic=
	[
		['Bold', 'Italic','Underline','Smiley','TextColor','BGColor','Font','FontSize','-','JustifyLeft','JustifyCenter','JustifyRight','-','Outdent','Indent','BidiLtr','BidiRtl','NumberedList', 'BulletedList'],
		['Link', 'Unlink','-','Image','-','Undo','Redo','-','Maximize']
	];
};

CKEDITOR.on( 'dialogDefinition', function( ev ) 
{
	// Take the dialog name and its definition from the event data.
	var dialogName = ev.data.name;
	var dialogDefinition = ev.data.definition;

	if ( dialogName == 'link' ) 
	{
		var targetTab = dialogDefinition.getContents( 'target' );
		// Set the default value for the URL field.
		var targetField = targetTab.get( 'linkTargetType' );
		var targetName = targetTab.get( 'linkTargetName' );
		targetField[ 'default' ] = '_blank';
		targetName[ 'default' ] = '_blank';
		dialogDefinition.removeContents( 'advanced' ); //We removed advanced tab from link dialog box
		dialogDefinition.removeContents( 'target' );
	}
	
	if ( dialogName == 'image' )
	{
		dialogDefinition.removeContents( 'advanced' ); 
		dialogDefinition.removeContents( 'Link' );

		//IMPORTANT NOTE: if you need to remove preview text i.e. "Lorem ipsum dolor sit amet, etc", go to ckeditor\plugins\image\dialogs
		//and change image_empty_preview.js to image.js. That's it. The image.js has to be renamed to image_nonempty_preview.js or whatever name appropriate.
	}
});
