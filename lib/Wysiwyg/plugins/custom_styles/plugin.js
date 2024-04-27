// get all the content editors (acf - #acf_content and wordpress - #content)
const contentEditors = tinyMCE.EditorManager.get();

// loop over each editor and update the spacing formats with tailwind config spacing options
contentEditors.forEach(contentEditor => {
  contentEditor.settings.style_formats.push( window.bottomSpacing );
  contentEditor.settings.style_formats.push( window.topSpacing );
  contentEditor.settings.style_formats.push( window.topBottomSpacing );
});
