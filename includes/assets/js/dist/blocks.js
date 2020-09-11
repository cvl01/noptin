!function(t){var e={};function n(o){if(e[o])return e[o].exports;var i=e[o]={i:o,l:!1,exports:{}};return t[o].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=t,n.c=e,n.d=function(t,e,o){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var i in t)n.d(o,i,function(e){return t[e]}.bind(null,i));return o},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=225)}({225:function(t,e){var n,o,i,r,l,a,s,c,p,u;n=window.wp.blocks,o=window.wp.editor,i=window.wp.i18n,r=window.wp.element,l=window.wp.components,window._,a=r.createElement,s=o.RichText,c=o.InspectorControls,p=o.ColorPalette,u=l.TextControl,n.registerBlockType("noptin/email-optin",{title:i.__("Newsletter Optin","noptin"),icon:"forms",category:"layout",attributes:{title:{type:"string",source:"children",selector:"h2",default:i.__("JOIN OUR NEWSLETTER","noptin")},description:{type:"string",source:"children",default:i.__("Click the above title to edit it. You can also edit this section by clicking on it.","noptin"),selector:".noptin_form_description"},button:{type:"string",default:"SUBSCRIBE"},bg_color:{type:"string",default:"#eeeeee"},title_color:{type:"string",default:"#313131"},text_color:{type:"string",default:"#32373c"},button_color:{type:"string",default:"#313131"},button_text_color:{type:"string",default:"#fafafa"}},edit:function(t){var e=t.attributes;return[a(c,{key:"controls"},a(l.PanelBody,{title:i.__("Button Text","noptin")},a(u,{value:e.button,type:"text",onChange:function(e){t.setAttributes({button:e})}})),a(l.PanelBody,{title:i.__("Redirect Url","noptin"),initialOpen:!1},a("h2",null,i.__("Redirect Url","noptin")),a("p",null,i.__("Optional. Where should we redirect users after they have successfully signed up?","noptin")),a(u,{value:e.redirect,placeholder:"http://example.com/download/gift.pdf",type:"url",onChange:function(e){t.setAttributes({redirect:e})}})),a(l.PanelBody,{title:i.__("Background Color","noptin"),initialOpen:!1},a(l.PanelRow,null,a(p,{onChange:function(e){t.setAttributes({bg_color:e})}}))),a(l.PanelBody,{title:i.__("Title Color","noptin"),initialOpen:!1},a(l.PanelRow,null,a(p,{onChange:function(e){t.setAttributes({title_color:e})}}))),a(l.PanelBody,{title:i.__("Description Color","noptin"),initialOpen:!1},a(l.PanelRow,null,a(p,{onChange:function(e){t.setAttributes({text_color:e})}}))),a(l.PanelBody,{title:i.__("Button Color","noptin"),initialOpen:!1},a("p",null,i.__("Text Color","noptin")),a(p,{onChange:function(e){t.setAttributes({button_text_color:e})}}),a("p",null,i.__("Background Color","noptin")),a(p,{onChange:function(e){t.setAttributes({button_color:e})}}))),a("div",{className:t.className,style:{backgroundColor:e.bg_color,padding:"20px",color:e.text_color}},a("form",{},a(s,{tagName:"h2",inline:!0,style:{color:e.title_color,textAlign:"center"},placeholder:i.__("Write Form title…","noptin"),value:e.title,className:"noptin_form_title",onChange:function(e){t.setAttributes({title:e})}}),a(s,{tagName:"p",inline:!0,style:{textAlign:"center"},placeholder:i.__("Write Form Description","noptin"),value:e.description,className:"noptin_form_description",onChange:function(e){t.setAttributes({description:e})}}),a("input",{type:"email",className:"noptin_form_input_email",placeholder:"Email Address",required:!0}),a("input",{value:e.button,type:"submit",style:{backgroundColor:e.button_color,color:e.button_text_color},className:"noptin_form_submit"}),a("div",{style:{border:"1px solid rgba(6, 147, 227, 0.8)",display:"none",padding:"10px",marginTop:"10px"},className:"noptin_feedback_success"}),a("div",{style:{border:"1px solid rgba(227, 6, 37, 0.8)",display:"none",padding:"10px",marginTop:"10px"},className:"noptin_feedback_error"})))]},save:function(t){var e=t.attributes;return a("div",{className:t.className,style:{backgroundColor:e.bg_color,padding:"20px",color:e.text_color}},a("form",{},a(s.Content,{tagName:"h2",inline:!0,style:{color:e.title_color,textAlign:"center"},value:e.title,className:"noptin_form_title"}),a(s.Content,{tagName:"p",inline:!0,style:{textAlign:"center"},value:e.description,className:"noptin_form_description"}),a("input",{type:"email",className:"noptin_form_input_email",placeholder:"Email Address",required:!0}),a("input",{value:e.button,type:"submit",style:{backgroundColor:e.button_color,color:e.button_text_color},className:"noptin_form_submit"}),a("input",{value:e.redirect,type:"hidden",className:"noptin_form_redirect"}),a("div",{style:{border:"1px solid rgba(6, 147, 227, 0.8)",display:"none",padding:"10px",marginTop:"10px"},className:"noptin_feedback_success"}),a("div",{style:{border:"1px solid rgba(227, 6, 37, 0.8)",display:"none",padding:"10px",marginTop:"10px"},className:"noptin_feedback_error"})))}})}});