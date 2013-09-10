tinymce.PluginManager.add('syntaxhl', function(editor, url) {

	function dialogWrapper(callback) {
		return function() {
			callback();
		};
	}
  
  function showDialog() {
  	var data = {}, options = {}, option, selection = editor.selection, dom = editor.dom, selectedElm, anchorElm, initialCode;
  	var win, optio, relListCtrl, targetListCtrl;
  	
    selectedElm = selection.getNode();
		anchorElm = dom.getParent(selectedElm, 'pre');

		data.code = initialCode = anchorElm ? (anchorElm.innerText || anchorElm.textContent) : selection.getContent({format: 'text'});
		data.class = anchorElm ? dom.getAttrib(anchorElm, 'class') : '';
		options = data.class.split(';').filter(function(n){return n});
		for (var i = 0; i < options.length; i++) {
		  option = options[i].split(':');
		  if (option[0] === 'brush') {
		    data.brush = option[1];
		  } else if (option[0] === 'fontsize') {
		    data.fontsize = option[1];
		  } else if (option[0] === 'first-line') {
		    data.firstline = option[1];
		  } else if (option[0] === 'gutter') {
		    data.firstline = option[1];
		  } else if (option[0] === 'light') {
		    data.firstline = option[1];
		  } else if (option[0] === 'collapse') {
		    data.firstline = option[1];
		  } else if (option[0] === 'highlight') {
		    data.firstline = option[1];
		  }
		}
		
		win = editor.windowManager.open({
		  width: 800,
		  height: 500,
			title: 'Insert/edit code',
			data: data,
			body: [
			  {type: 'listbox', name: 'brush', label: 'Language', values: [
          {text: 'Bash/Shell', value: 'bash'},
          {text: 'CSS', value: 'css'},
          {text: 'Jscript', value: 'jscript'},
          {text: 'PHP', value: 'php'},
          {text: 'SQL', value: 'sql'}
        ]},
        {type: 'textbox', name: 'firstline', label: 'First Line', value: '1'},
        {type: 'textbox', name: 'fontsize', label: 'Font Size', value: '100%'},
        {type: 'textbox', name: 'code', label: 'Code', multiline: true, style: 'height:200px;'},
        {type: 'checkbox', name: 'gutter', label: 'No Gutter'},
        {type: 'checkbox', name: 'light', label: 'Light'},
        {type: 'checkbox', name: 'collapse', label: 'Collapse'},
        {type: 'textbox', name: 'highlight', label: 'Highlight'},
			],
			onSubmit: function(e) {
				if(e.data.code == '') {
          return false;
        }
    
        var options = "";
        if(e.data.brush != '') {
          options += 'brush:' + e.data.brush + ';';
        }
        if(e.data.gutter) {
          options += 'gutter:false;';
        }
        if(e.data.light) {
          options += 'light:true;';
        }
        if(e.data.collapse) {
          options += 'collapse:true;';
        }
        if(e.data.fontsize != '') {
          var fontsize=parseInt(e.data.fontsize);
          options += 'fontsize:' + fontsize + ';';
        }
        if(e.data.firstline != '') {
          var linenumber = parseInt(e.data.firstline);
          options += 'first-line:' + linenumber + ';';
        }
        if(e.data.highlight != '') {
          options += 'highlight:[' + e.data.highlight + '];';
        }
        
        var content = '<pre class="';
        content += options + '">';
        content += editor.dom.encode(e.data.code);
        content += '</pre> ';
        
        if (anchorElm) {
					editor.focus();
					anchorElm.innerHTML = editor.dom.encode(e.data.code);

					dom.setAttribs(anchorElm, {
						class: options
					});

					selection.select(anchorElm);
				} else {
				  editor.insertContent(content);
				}
			}
		});
  }
  
  editor.on('init', function() {
    editor.dom.loadCSS(url + '/css/preelementfix.css');
  });
  
	editor.addButton('syntaxhl', {
		icon: 'code',
		tooltip: 'Insert/edit code',
		onclick: dialogWrapper(showDialog),
		stateSelector: 'pre[class]'
	});
  
});