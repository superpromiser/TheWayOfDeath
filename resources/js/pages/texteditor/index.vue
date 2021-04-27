<template>
    <div class="content">
      <h1>pell</h1>
      <div id="editor" class="pell"></div>
      <div style="margin-top:20px;">
        <h3>Text output:</h3>
        <div id="text-output"></div>
      </div>
      <div style="margin-top:20px;">
        <h3>HTML output:</h3>
        <pre id="html-output"></pre>
      </div>
    </div>
</template>

<script>

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };
export default {
    // data: ()=> ({
    //     defaultParagraphSeparatorString : 'defaultParagraphSeparator',
    //     formatBlock : 'formatBlock',
    //     defaultActions: {
    //         bold: {
    //             icon: '<b>B</b>',
    //             title: 'Bold',
    //             state: function state() {
    //                 return this.queryCommandState('bold');
    //             },
    //             result: function result() {
    //                 return this.exec('bold');
    //             }
    //         },
    //         italic: {
    //             icon: '<i>I</i>',
    //             title: 'Italic',
    //             state: function state() {
    //                 return this.queryCommandState('italic');
    //             },
    //             result: function result() {
    //                 return this.exec('italic');
    //             }
    //         },
    //         underline: {
    //             icon: '<u>U</u>',
    //             title: 'Underline',
    //             state: function state() {
    //                 return this.queryCommandState('underline');
    //             },
    //             result: function result() {
    //                 return this.exec('underline');
    //             }
    //         },
    //         strikethrough: {
    //             icon: '<strike>S</strike>',
    //             title: 'Strike-through',
    //             state: function state() {
    //             return this.queryCommandState('strikeThrough');
    //             },
    //             result: function result() {
    //             return this.exec('strikeThrough');
    //             }
    //         },
    //         heading1: {
    //             icon: '<b>H<sub>1</sub></b>',
    //             title: 'Heading 1',
    //             result: function result() {
    //             return this.exec('formatBlock', '<h1>');
    //             }
    //         },
    //         heading2: {
    //             icon: '<b>H<sub>2</sub></b>',
    //             title: 'Heading 2',
    //             result: function result() {
    //             return this.exec('formatBlock', '<h2>');
    //             }
    //         },
    //         paragraph: {
    //             icon: '&#182;',
    //             title: 'Paragraph',
    //             result: function result() {
    //             return this.exec('formatBlock', '<p>');
    //             }
    //         },
    //         quote: {
    //             icon: '&#8220; &#8221;',
    //             title: 'Quote',
    //             result: function result() {
    //             return this.exec('formatBlock', '<blockquote>');
    //             }
    //         },
    //         olist: {
    //             icon: '&#35;',
    //             title: 'Ordered List',
    //             result: function result() {
    //             return this.exec('insertOrderedList');
    //             }
    //         },
    //         ulist: {
    //             icon: '&#8226;',
    //             title: 'Unordered List',
    //             result: function result() {
    //             return this.exec('insertUnorderedList');
    //             }
    //         },
    //         code: {
    //             icon: '&lt;/&gt;',
    //             title: 'Code',
    //             result: function result() {
    //             return this.exec('formatBlock', '<pre>');
    //             }
    //         },
    //         line: {
    //             icon: '&#8213;',
    //             title: 'Horizontal Line',
    //             result: function result() {
    //             return this.exec('insertHorizontalRule');
    //             }
    //         },
    //         link: {
    //             icon: '&#128279;',
    //             title: 'Link',
    //             result: function result() {
    //             var url = window.prompt('Enter the link URL');
    //             if (url) this.exec('createLink', url);
    //             }
    //         },
    //         image: {
    //             icon: '&#128247;',
    //             title: 'Image',
    //             result: function result() {
    //             var url = window.prompt('Enter the image URL');
    //             if (url) this.exec('insertImage', url);
    //             }
    //         }
    //     },

    //     defaultClasses: {
    //         actionbar: 'pell-actionbar',
    //         button: 'pell-button',
    //         content: 'pell-content',
    //         selected: 'pell-button-selected'
    //     },
    // }),

    data(){
        return{
            defaultParagraphSeparatorString : 'defaultParagraphSeparator',
            formatBlock : 'formatBlock',
            defaultActions: {
                bold: {
                    icon: '<b>B</b>',
                    title: 'Bold',
                    state: function state() {
                        return this.queryCommandState('bold');
                    },
                    result: function result() {
                        return this.exec('bold');
                    }
                },
                italic: {
                    icon: '<i>I</i>',
                    title: 'Italic',
                    state: function state() {
                        return this.queryCommandState('italic');
                    },
                    result: function result() {
                        return this.exec('italic');
                    }
                },
                underline: {
                    icon: '<u>U</u>',
                    title: 'Underline',
                    state: function state() {
                        return this.queryCommandState('underline');
                    },
                    result: function result() {
                        return this.exec('underline');
                    }
                },
                strikethrough: {
                    icon: '<strike>S</strike>',
                    title: 'Strike-through',
                    state: function state() {
                    return this.queryCommandState('strikeThrough');
                    },
                    result: function result() {
                    return this.exec('strikeThrough');
                    }
                },
                heading1: {
                    icon: '<b>H<sub>1</sub></b>',
                    title: 'Heading 1',
                    result: function result() {
                    return this.exec('formatBlock', '<h1>');
                    }
                },
                heading2: {
                    icon: '<b>H<sub>2</sub></b>',
                    title: 'Heading 2',
                    result: function result() {
                    return this.exec('formatBlock', '<h2>');
                    }
                },
                paragraph: {
                    icon: '&#182;',
                    title: 'Paragraph',
                    result: function result() {
                    return this.exec('formatBlock', '<p>');
                    }
                },
                quote: {
                    icon: '&#8220; &#8221;',
                    title: 'Quote',
                    result: function result() {
                    return this.exec('formatBlock', '<blockquote>');
                    }
                },
                olist: {
                    icon: '&#35;',
                    title: 'Ordered List',
                    result: function result() {
                    return this.exec('insertOrderedList');
                    }
                },
                ulist: {
                    icon: '&#8226;',
                    title: 'Unordered List',
                    result: function result() {
                    return this.exec('insertUnorderedList');
                    }
                },
                code: {
                    icon: '&lt;/&gt;',
                    title: 'Code',
                    result: function result() {
                    return this.exec('formatBlock', '<pre>');
                    }
                },
                line: {
                    icon: '&#8213;',
                    title: 'Horizontal Line',
                    result: function result() {
                    return this.exec('insertHorizontalRule');
                    }
                },
                link: {
                    icon: '&#128279;',
                    title: 'Link',
                    result: function result() {
                    var url = window.prompt('Enter the link URL');
                    if (url) this.exec('createLink', url);
                    }
                },
                image: {
                    icon: '&#128247;',
                    title: 'Image',
                    result: function result() {
                    var url = window.prompt('Enter the image URL');
                    if (url) this.exec('insertImage', url);
                    }
                }
            },

            defaultClasses: {
                actionbar: 'pell-actionbar',
                button: 'pell-button',
                content: 'pell-content',
                selected: 'pell-button-selected'
            },
        }
    },

    mounted(){
        console.log("this.defaultActions", this.defaultActions);
        this.init(
            {   
                element: document.getElementById('editor'),
                defaultParagraphSeparator: 'p',
                // actions: [
                //     'bold',
                //     'italic',
                //     'underline',
                //     'strikethrough'
                // ],
                onChange: function (html) {
                    document.getElementById('text-output').innerHTML = html
                    document.getElementById('html-output').textContent = html
                }
            }
        );
    },

    methods:{
        addEventListener(parent, type, listener) {
            return parent.addEventListener(type, listener);
        },
        appendChild(parent, child) {
            return parent.appendChild(child);
        },
        createElement(tag) {
            console.log("2222",tag);
            return document.createElement(tag);
        },
        queryCommandState(command) {
            return document.queryCommandState(command);
        },
        queryCommandValue(command) {
            return document.queryCommandValue(command);
        },
        exec(command) {
            var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
            return document.execCommand(command, false, value);
        },

        init(settings){
            var actions = settings.actions ? settings.actions.map( action => {
                if (typeof action === 'string') return this.defaultActions[action];
                else if (this.defaultActions[action.name]) return _extends({}, this.defaultActions[action.name], action);
                return action;
            }) : Object.keys(this.defaultActions).map( action => {
                return this.defaultActions[action];
            });

            var classes = _extends({}, this.defaultClasses, settings.classes);

            var defaultParagraphSeparator = settings[this.defaultParagraphSeparatorString] || 'div';

            var actionbar = this.createElement('div');
            actionbar.className = classes.actionbar;
            this.appendChild(settings.element, actionbar);

            var content = settings.element.content = this.createElement('div');
            content.contentEditable = true;
            content.className = classes.content;
            content.oninput = function (_ref) {
                var firstChild = _ref.target.firstChild;

                if (firstChild && firstChild.nodeType === 3) this.exec(this.formatBlock, '<' + defaultParagraphSeparator + '>');else if (content.innerHTML === '<br>') content.innerHTML = '';
                settings.onChange(content.innerHTML);
            };
            content.onkeydown = function (event) {
                if (event.key === 'Enter' && this.queryCommandValue(this.formatBlock) === 'blockquote') {
                setTimeout(function () {
                    return this.exec(this.formatBlock, '<' + defaultParagraphSeparator + '>');
                }, 0);
                }
            };
            this.appendChild(settings.element, content);

            for(let i = 0; i < actions.length ; i++){
                var button = this.createElement('button');
                button.className = classes.button;
                button.innerHTML = actions[i].icon;
                button.title = actions[i].title;
                button.setAttribute('type', 'button');
                button.onclick = function () {
                return actions[i].result() && content.focus();
                };

                if (actions[i].state) {
                var handler = function handler() {
                    return button.classList[actions[i].state() ? 'add' : 'remove'](classes.selected);
                };
                this.addEventListener(content, 'keyup', handler);
                this.addEventListener(content, 'mouseup', handler);
                this.addEventListener(button, 'click', handler);
                }

                this.appendChild(actionbar, button);
            }

            if (settings.styleWithCSS) this.exec('styleWithCSS');
            this.exec(this.defaultParagraphSeparatorString, defaultParagraphSeparator);

            return settings.element;
        }
    }
}
</script>
    
<style>
    .content {
        box-sizing: border-box;
        margin: 0 auto;
        max-width: 600px;
        padding: 20px;
      }

      #html-output {
        white-space: pre-wrap;
      }
      .pell {
  border: 1px solid rgba(10, 10, 10, 0.1);
  box-sizing: border-box; }

.pell-content {
  box-sizing: border-box;
  height: 300px;
  outline: 0;
  overflow-y: auto;
  padding: 10px; }

.pell-actionbar {
  background-color: #FFF;
  border-bottom: 1px solid rgba(10, 10, 10, 0.1); }

.pell-button {
  background-color: transparent;
  border: none;
  cursor: pointer;
  height: 30px;
  outline: 0;
  width: 30px;
  vertical-align: bottom; }

.pell-button-selected {
  background-color: #F0F0F0; }

</style>