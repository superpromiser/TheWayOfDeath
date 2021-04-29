<template>
    <v-container fluid class="bg-secondary">
        <div id="editor" class="pell"></div>
        <!-- <div style="margin-top:20px;">
            <h3>Text output:</h3>
            <div id="text-output"></div>
        </div>
        <div style="margin-top:20px;">
            <h3>HTML output:</h3>
            <pre id="html-output"></pre>
        </div> -->
        <v-btn-toggle
            v-model="toggle_none" style="right: 15px;"
            background-color="#E0E0E0" class="rounded-lg position-fixed" :class="isOpenSetting? 'opened-setting-pell': 'closed-setting-pell'"
        >
            <v-btn v-if="pellSetting" @click="openKeyBoard">
                <v-icon size="22">mdi-format-underline</v-icon>
            </v-btn>
            <v-btn v-else @click="pellSettingTrue">
                <v-icon size="22">mdi-format-underline</v-icon>
            </v-btn>
            <v-btn @click="toggleImageFile">
                <v-icon size="22">mdi-file-image-outline</v-icon>
            </v-btn>
        </v-btn-toggle>
        <v-bottom-sheet v-model="pellSetting">
            <v-sheet class="py-3">
                <v-container>
                    <v-item-group class="row ma-0">
                        <v-item class="col col-50 d-flex justify-center align-center">
                            <p class="mb-0 font-color-gray-heavy">字号</p>
                        </v-item>
                        <v-item v-slot="{ active, toggle }" class="col col-50 d-flex justify-center align-center text-center">
                            <div>
                                <div>
                                    <v-chip active-class="purple--text" class="mo-text-editor-setting-chip" :input-value="active" @click="toggle">
                                        <v-icon size="18">mdi-format-color-text</v-icon> 
                                    </v-chip>
                                    <p class="mb-0 pt-2 font-size-0-70 font-color-gray-heavy">小</p>
                                </div>
                            </div>
                        </v-item>
                        <v-item v-slot="{ active, toggle }" class="col col-50 d-flex justify-center align-center text-center">
                            <div>
                                <div>
                                    <v-chip active-class="purple--text" class="mo-text-editor-setting-chip" :input-value="active" @click="toggle">
                                        <v-icon size="23">mdi-format-color-text</v-icon> 
                                    </v-chip>
                                    <p class="mb-0 pt-2 font-size-0-70 font-color-gray-heavy">默认</p>
                                </div>
                            </div>
                        </v-item>
                        <v-item v-slot="{ active, toggle }" class="col col-50 d-flex justify-center align-center text-center">
                            <div>
                                <div>
                                    <v-chip active-class="purple--text" class="mo-text-editor-setting-chip" :input-value="active" @click="toggle">
                                        <v-icon size="30">mdi-format-color-text</v-icon> 
                                    </v-chip>
                                    <p class="mb-0 pt-2 font-size-0-70 font-color-gray-heavy">大</p>
                                </div>
                            </div>
                        </v-item>
                        <v-item v-slot="{ active, toggle }" class="col col-50 d-flex justify-center align-center text-center">
                            <div>
                                <div>
                                    <v-chip active-class="purple--text" class="mo-text-editor-setting-chip" :input-value="active" @click="toggle">
                                        <v-icon size="40">mdi-format-color-text</v-icon> 
                                    </v-chip>
                                    <p class="mb-0 pt-2 font-size-0-70 font-color-gray-heavy">特大</p>
                                </div>
                            </div>
                        </v-item>
                    </v-item-group>
                    <v-item-group class="row ma-0">
                        <v-item class="col col-50 d-flex justify-center align-center">
                            <p class="mb-0 font-color-gray-heavy">字色</p>
                        </v-item>
                        <v-item v-slot="{ active, toggle }" class="col col-50 d-flex justify-center align-center text-center">
                            <div>
                                <div>
                                    <v-chip active-class="purple--text" class="mo-text-editor-setting-chip" :input-value="active" @click="toggle">
                                        <v-icon size="30" color="#222222">mdi-circle</v-icon> 
                                    </v-chip>
                                    <p class="mb-0 pt-2 font-size-0-70 font-color-gray-heavy">小</p>
                                </div>
                            </div>
                        </v-item>
                        <v-item v-slot="{ active, toggle }" class="col col-50 d-flex justify-center align-center text-center">
                            <div>
                                <div>
                                    <v-chip active-class="purple--text" class="mo-text-editor-setting-chip" :input-value="active" @click="toggle">
                                        <v-icon size="30" color="#7879ff">mdi-circle</v-icon> 
                                    </v-chip>
                                    <p class="mb-0 pt-2 font-size-0-70 font-color-gray-heavy">默认</p>
                                </div>
                            </div>
                        </v-item>
                        <v-item v-slot="{ active, toggle }" class="col col-50 d-flex justify-center align-center text-center">
                            <div>
                                <div>
                                    <v-chip active-class="purple--text" class="mo-text-editor-setting-chip" :input-value="active" @click="toggle">
                                        <v-icon size="30" color="#3989fc">mdi-circle</v-icon> 
                                    </v-chip>
                                    <p class="mb-0 pt-2 font-size-0-70 font-color-gray-heavy">大</p>
                                </div>
                            </div>
                        </v-item>
                        <v-item v-slot="{ active, toggle }" class="col col-50 d-flex justify-center align-center text-center">
                            <div>
                                <div>
                                    <v-chip active-class="purple--text" class="mo-text-editor-setting-chip" :input-value="active" @click="toggle">
                                        <v-icon size="30" color="#49d29e">mdi-circle</v-icon> 
                                    </v-chip>
                                    <p class="mb-0 pt-2 font-size-0-70 font-color-gray-heavy">特大</p>
                                </div>
                            </div>
                        </v-item>
                    </v-item-group>
                </v-container>
            </v-sheet>
        </v-bottom-sheet>
    </v-container>
</template>

<script>

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };
var exec = function exec(command) {
  var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  return document.execCommand(command, false, value);
};
export default {
    data: ()=> ({
        defaultParagraphSeparatorString : 'defaultParagraphSeparator',
        formatBlock : 'formatBlock',
        defaultActions: {
            bold: {
                icon: '<b>B</b>',
                title: 'Bold',
                state: function state() {
                    return document.queryCommandState('bold');
                },
                result: function result() {
                    return exec('bold');
                }
            },
            italic: {
                icon: '<i>I</i>',
                title: 'Italic',
                state: function state() {
                    return document.queryCommandState('italic');
                },
                result: function result() {
                    return exec('italic');
                }
            },
            underline: {
                icon: '<u>U</u>',
                title: 'Underline',
                state: function state() {
                    return document.queryCommandState('underline');
                },
                result: function result() {
                    return exec('underline');
                }
            },
            strikethrough: {
                icon: '<strike>S</strike>',
                title: 'Strike-through',
                state: function state() {
                return document.queryCommandState('strikeThrough');
                },
                result: function result() {
                return exec('strikeThrough');
                }
            },
            heading1: {
                icon: '<b>H<sub>1</sub></b>',
                title: 'Heading 1',
                result: function result() {
                return exec('formatBlock', '<h1>');
                }
            },
            heading2: {
                icon: '<b>H<sub>2</sub></b>',
                title: 'Heading 2',
                result: function result() {
                return exec('formatBlock', '<h2>');
                }
            },
            paragraph: {
                icon: '&#182;',
                title: 'Paragraph',
                result: function result() {
                return exec('formatBlock', '<p>');
                }
            },
            quote: {
                icon: '&#8220; &#8221;',
                title: 'Quote',
                result: function result() {
                return exec('formatBlock', '<blockquote>');
                }
            },
            olist: {
                icon: '&#35;',
                title: 'Ordered List',
                result: function result() {
                return exec('insertOrderedList');
                }
            },
            ulist: {
                icon: '&#8226;',
                title: 'Unordered List',
                result: function result() {
                return exec('insertUnorderedList');
                }
            },
            code: {
                icon: '&lt;/&gt;',
                title: 'Code',
                result: function result() {
                return exec('formatBlock', '<pre>');
                }
            },
            line: {
                icon: '&#8213;',
                title: 'Horizontal Line',
                result: function result() {
                return exec('insertHorizontalRule');
                }
            },
            link: {
                icon: '&#128279;',
                title: 'Link',
                result: function result() {
                var url = window.prompt('Enter the link URL');
                if (url) exec('createLink', url);
                }
            },
            image: {
                icon: '&#128247;',
                title: 'Image',
                result: function result() {
                var url = window.prompt('Enter the image URL');
                if (url) exec('insertImage', url);
                }
            }
        },

        defaultClasses: {
            actionbar: 'pell-actionbar',
            button: 'pell-button',
            content: 'pell-content',
            selected: 'pell-button-selected'
        },

        toggle_none: null,
        isOpenSetting: false,
        pellSetting: false,
    }),

    mounted(){
        this.init(
            {   
                element: document.getElementById('editor'),
                defaultParagraphSeparator: 'p',
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
            return document.createElement(tag);
        },
        queryCommandState(command) {
            return document.queryCommandState(command);
        },
        queryCommandValue(command) {
            return document.queryCommandValue(command);
        },
        // exec(command) {
        //     var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
        //     return document.execCommand(command, false, value);
        // },

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

                if (firstChild && firstChild.nodeType === 3) exec(this.formatBlock, '<' + defaultParagraphSeparator + '>');else if (content.innerHTML === '<br>') content.innerHTML = '';
                settings.onChange(content.innerHTML);
            };
            content.onkeydown = function (event) {
                if (event.key === 'Enter' && document.queryCommandValue(this.formatBlock) === 'blockquote') {
                setTimeout(function () {
                    return exec(this.formatBlock, '<' + defaultParagraphSeparator + '>');
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

            if (settings.styleWithCSS) exec('styleWithCSS');
            exec(this.defaultParagraphSeparatorString, defaultParagraphSeparator);

            return settings.element;
        },


        pellSettingTrue(){
            this.pellSetting = true;
        },

        toggleImageFile(){

        },

        openKeyBoard(){

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