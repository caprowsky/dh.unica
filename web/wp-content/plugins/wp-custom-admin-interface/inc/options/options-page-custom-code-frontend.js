jQuery(document).ready(function ($) {
    
    var cssCodeFrontend = CodeMirror.fromTextArea(document.getElementById("wp_custom_admin_interface_custom_frontend_css_code"), {
        lineNumbers: true,
        lineWrapping: true,
        mode: "css",
        theme: "blackboard",
        matchBrackets: true,
        autoCloseTags: true,
        autoCloseBrackets: true,
        viewportMargin: Infinity
    });
    
    var javascriptCodeFrontend = CodeMirror.fromTextArea(document.getElementById("wp_custom_admin_interface_custom_javascript_code"), {
        lineNumbers: true,
        lineWrapping: true,
        mode: "javascript",
        theme: "blackboard",    
        matchBrackets: true,
        autoCloseTags: true,
        autoCloseBrackets: true,
        viewportMargin: Infinity
    });
    
});