/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  config.toolbarGroups = [
    { name: "document", groups: ["mode", "document", "doctools"] },
    { name: "clipboard", groups: ["clipboard", "undo"] },
    // { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    { name: "forms", groups: ["forms"] },
    { name: "basicstyles", groups: ["basicstyles", "cleanup"] },
    {
      name: "paragraph",
      groups: ["list", "indent", "blocks", "align", "bidi", "paragraph"],
    },
    { name: "links", groups: ["links"] },
    { name: "insert", groups: ["insert"] },
    { name: "styles", groups: ["styles"] },
    { name: "colors", groups: ["colors"] },
    { name: "others", groups: ["others"] },
    { name: "tools", groups: ["tools"] },
    { name: "about", groups: ["about"] },
  ];

  config.uiColor = "#ffffff";

  config.removeButtons =
    "Copy,Cut,Paste,PasteText,PasteFromWord,Save,NewPage,ExportPdf,Preview,Print,Templates,Find,Replace,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,Outdent,Indent,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,HorizontalRule,PageBreak,Iframe,Strike,Styles,Font,FontSize,ShowBlocks,About,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock";

  config.allowedContent = true;

  // Set the most common block elements.
  config.format_tags = "h2;h3;h4;p";

  // To disable image tabs
  config.removeDialogTabs = "image:advanced;image:Link;image:Upload";

  config.extraPlugins = "wordcount,scayt";

  config.disableNativeSpellChecker = false;
};

CKEDITOR.dtd.$removeEmpty["span"] = false;
CKEDITOR.dtd.$removeEmpty["i"] = false;
