<!DOCTYPE html>
<html>
<head>
  <title>readme</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /**
 * prism.js Github theme based on GitHub's theme.
 * @author Sam Clarke
 */
code[class*="language-"],
pre[class*="language-"] {
  color: #333;
  background: none;
  font-family: Consolas, "Liberation Mono", Menlo, Courier, monospace;
  text-align: left;
  white-space: pre;
  word-spacing: normal;
  word-break: normal;
  word-wrap: normal;
  line-height: 1.4;

  -moz-tab-size: 8;
  -o-tab-size: 8;
  tab-size: 8;

  -webkit-hyphens: none;
  -moz-hyphens: none;
  -ms-hyphens: none;
  hyphens: none;
}

/* Code blocks */
pre[class*="language-"] {
  padding: .8em;
  overflow: auto;
  /* border: 1px solid #ddd; */
  border-radius: 3px;
  /* background: #fff; */
  background: #f5f5f5;
}

/* Inline code */
:not(pre) > code[class*="language-"] {
  padding: .1em;
  border-radius: .3em;
  white-space: normal;
  background: #f5f5f5;
}

.token.comment,
.token.blockquote {
  color: #969896;
}

.token.cdata {
  color: #183691;
}

.token.doctype,
.token.punctuation,
.token.variable,
.token.macro.property {
  color: #333;
}

.token.operator,
.token.important,
.token.keyword,
.token.rule,
.token.builtin {
  color: #a71d5d;
}

.token.string,
.token.url,
.token.regex,
.token.attr-value {
  color: #183691;
}

.token.property,
.token.number,
.token.boolean,
.token.entity,
.token.atrule,
.token.constant,
.token.symbol,
.token.command,
.token.code {
  color: #0086b3;
}

.token.tag,
.token.selector,
.token.prolog {
  color: #63a35c;
}

.token.function,
.token.namespace,
.token.pseudo-element,
.token.class,
.token.class-name,
.token.pseudo-class,
.token.id,
.token.url-reference .token.variable,
.token.attr-name {
  color: #795da3;
}

.token.entity {
  cursor: help;
}

.token.title,
.token.title .token.punctuation {
  font-weight: bold;
  color: #1d3e81;
}

.token.list {
  color: #ed6a43;
}

.token.inserted {
  background-color: #eaffea;
  color: #55a532;
}

.token.deleted {
  background-color: #ffecec;
  color: #bd2c00;
}

.token.bold {
  font-weight: bold;
}

.token.italic {
  font-style: italic;
}


/* JSON */
.language-json .token.property {
  color: #183691;
}

.language-markup .token.tag .token.punctuation {
  color: #333;
}

/* CSS */
code.language-css,
.language-css .token.function {
  color: #0086b3;
}

/* YAML */
.language-yaml .token.atrule {
  color: #63a35c;
}

code.language-yaml {
  color: #183691;
}

/* Ruby */
.language-ruby .token.function {
  color: #333;
}

/* Markdown */
.language-markdown .token.url {
  color: #795da3;
}

/* Makefile */
.language-makefile .token.symbol {
  color: #795da3;
}

.language-makefile .token.variable {
  color: #183691;
}

.language-makefile .token.builtin {
  color: #0086b3;
}

/* Bash */
.language-bash .token.keyword {
  color: #0086b3;
}

/* highlight */
pre[data-line] {
  position: relative;
  padding: 1em 0 1em 3em;
}
pre[data-line] .line-highlight-wrapper {
  position: absolute;
  top: 0;
  left: 0;
  background-color: transparent;
  display: block;
  width: 100%;
}

pre[data-line] .line-highlight {
  position: absolute;
  left: 0;
  right: 0;
  padding: inherit 0;
  margin-top: 1em;
  background: hsla(24, 20%, 50%,.08);
  background: linear-gradient(to right, hsla(24, 20%, 50%,.1) 70%, hsla(24, 20%, 50%,0));
  pointer-events: none;
  line-height: inherit;
  white-space: pre;
}

pre[data-line] .line-highlight:before, 
pre[data-line] .line-highlight[data-end]:after {
  content: attr(data-start);
  position: absolute;
  top: .4em;
  left: .6em;
  min-width: 1em;
  padding: 0 .5em;
  background-color: hsla(24, 20%, 50%,.4);
  color: hsl(24, 20%, 95%);
  font: bold 65%/1.5 sans-serif;
  text-align: center;
  vertical-align: .3em;
  border-radius: 999px;
  text-shadow: none;
  box-shadow: 0 1px white;
}

pre[data-line] .line-highlight[data-end]:after {
  content: attr(data-end);
  top: auto;
  bottom: .4em;
}html body{font-family:"Helvetica Neue",Helvetica,"Segoe UI",Arial,freesans,sans-serif;font-size:16px;line-height:1.6;color:#333;background-color:#fff;overflow:initial;box-sizing:border-box;word-wrap:break-word}html body>:first-child{margin-top:0}html body h1,html body h2,html body h3,html body h4,html body h5,html body h6{line-height:1.2;margin-top:1em;margin-bottom:16px;color:#000}html body h1{font-size:2.25em;font-weight:300;padding-bottom:.3em}html body h2{font-size:1.75em;font-weight:400;padding-bottom:.3em}html body h3{font-size:1.5em;font-weight:500}html body h4{font-size:1.25em;font-weight:600}html body h5{font-size:1.1em;font-weight:600}html body h6{font-size:1em;font-weight:600}html body h1,html body h2,html body h3,html body h4,html body h5{font-weight:600}html body h5{font-size:1em}html body h6{color:#5c5c5c}html body strong{color:#000}html body del{color:#5c5c5c}html body a:not([href]){color:inherit;text-decoration:none}html body a{color:#08c;text-decoration:none}html body a:hover{color:#00a3f5;text-decoration:none}html body img{max-width:100%}html body>p{margin-top:0;margin-bottom:16px;word-wrap:break-word}html body>ul,html body>ol{margin-bottom:16px}html body ul,html body ol{padding-left:2em}html body ul.no-list,html body ol.no-list{padding:0;list-style-type:none}html body ul ul,html body ul ol,html body ol ol,html body ol ul{margin-top:0;margin-bottom:0}html body li{margin-bottom:0}html body li.task-list-item{list-style:none}html body li>p{margin-top:0;margin-bottom:0}html body .task-list-item-checkbox{margin:0 .2em .25em -1.8em;vertical-align:middle}html body .task-list-item-checkbox:hover{cursor:pointer}html body blockquote{margin:16px 0;font-size:inherit;padding:0 15px;color:#5c5c5c;background-color:#f0f0f0;border-left:4px solid #d6d6d6}html body blockquote>:first-child{margin-top:0}html body blockquote>:last-child{margin-bottom:0}html body hr{height:4px;margin:32px 0;background-color:#d6d6d6;border:0 none}html body table{margin:10px 0 15px 0;border-collapse:collapse;border-spacing:0;display:block;width:100%;overflow:auto;word-break:normal;word-break:keep-all}html body table th{font-weight:bold;color:#000}html body table td,html body table th{border:1px solid #d6d6d6;padding:6px 13px}html body dl{padding:0}html body dl dt{padding:0;margin-top:16px;font-size:1em;font-style:italic;font-weight:bold}html body dl dd{padding:0 16px;margin-bottom:16px}html body code{font-family:Menlo,Monaco,Consolas,'Courier New',monospace;font-size:.85em !important;color:#000;background-color:#f0f0f0;border-radius:3px;padding:.2em 0}html body code::before,html body code::after{letter-spacing:-0.2em;content:"\00a0"}html body pre>code{padding:0;margin:0;font-size:.85em !important;word-break:normal;white-space:pre;background:transparent;border:0}html body .highlight{margin-bottom:16px}html body .highlight pre,html body pre{padding:1em;overflow:auto;font-size:.85em !important;line-height:1.45;border:#d6d6d6;border-radius:3px}html body .highlight pre{margin-bottom:0;word-break:normal}html body pre code,html body pre tt{display:inline;max-width:initial;padding:0;margin:0;overflow:initial;line-height:inherit;word-wrap:normal;background-color:transparent;border:0}html body pre code:before,html body pre tt:before,html body pre code:after,html body pre tt:after{content:normal}html body p,html body blockquote,html body ul,html body ol,html body dl,html body pre{margin-top:0;margin-bottom:16px}html body kbd{color:#000;border:1px solid #d6d6d6;border-bottom:2px solid #c7c7c7;padding:2px 4px;background-color:#f0f0f0;border-radius:3px}@media print{html body{background-color:#fff}html body h1,html body h2,html body h3,html body h4,html body h5,html body h6{color:#000;page-break-after:avoid}html body blockquote{color:#5c5c5c}html body pre{page-break-inside:avoid}html body table{display:table}html body img{display:block;max-width:100%;max-height:100%}html body pre,html body code{word-wrap:break-word;white-space:pre}}.markdown-preview{width:1000px;height:100%;box-sizing:border-box;margin:0 auto;}.markdown-preview .pagebreak,.markdown-preview .newpage{page-break-before:always}.markdown-preview pre.line-numbers{position:relative;padding-left:3.8em;counter-reset:linenumber}.markdown-preview pre.line-numbers>code{position:relative}.markdown-preview pre.line-numbers .line-numbers-rows{position:absolute;pointer-events:none;top:1em;font-size:100%;left:0;width:3em;letter-spacing:-1px;border-right:1px solid #999;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.markdown-preview pre.line-numbers .line-numbers-rows>span{pointer-events:none;display:block;counter-increment:linenumber}.markdown-preview pre.line-numbers .line-numbers-rows>span:before{content:counter(linenumber);color:#999;display:block;padding-right:.8em;text-align:right}.markdown-preview .mathjax-exps .MathJax_Display{text-align:center !important}.markdown-preview:not([for="preview"]) .code-chunk .btn-group{display:none}.markdown-preview:not([for="preview"]) .code-chunk .status{display:none}.markdown-preview:not([for="preview"]) .code-chunk .output-div{margin-bottom:16px}.scrollbar-style::-webkit-scrollbar{width:8px}.scrollbar-style::-webkit-scrollbar-track{border-radius:10px;background-color:transparent}.scrollbar-style::-webkit-scrollbar-thumb{border-radius:5px;background-color:rgba(150,150,150,0.66);border:4px solid rgba(150,150,150,0.66);background-clip:content-box}html body[for="html-export"]:not([data-presentation-mode]){position:relative;width:100%;height:100%;top:0;left:0;margin:0;padding:0;overflow:auto}html body[for="html-export"]:not([data-presentation-mode]) .markdown-preview{position:relative;top:0}@media screen and (min-width:914px){html body[for="html-export"]:not([data-presentation-mode]) .markdown-preview{padding:2em calc(50% - 457px + 2em)}}@media screen and (max-width:914px){html body[for="html-export"]:not([data-presentation-mode]) .markdown-preview{padding:2em}}@media screen and (max-width:450px){html body[for="html-export"]:not([data-presentation-mode]) .markdown-preview{font-size:14px !important;padding:1em}}@media print{html body[for="html-export"]:not([data-presentation-mode]) #sidebar-toc-btn{display:none}}html body[for="html-export"]:not([data-presentation-mode]) #sidebar-toc-btn{position:fixed;bottom:8px;left:8px;font-size:28px;cursor:pointer;color:inherit;z-index:99;width:32px;text-align:center;opacity:.4}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] #sidebar-toc-btn{opacity:1}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc{position:fixed;top:0;left:0;width:300px;height:100%;padding:32px 0 48px 0;font-size:14px;box-shadow:0 0 4px rgba(150,150,150,0.33);box-sizing:border-box;overflow:auto;background-color:inherit}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar{width:8px}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar-track{border-radius:10px;background-color:transparent}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar-thumb{border-radius:5px;background-color:rgba(150,150,150,0.66);border:4px solid rgba(150,150,150,0.66);background-clip:content-box}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc a{text-decoration:none}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc ul{padding:0 1.6em;margin-top:.8em}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc li{margin-bottom:.8em}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc ul{list-style-type:none}html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview{left:300px;width:calc(100% -  300px);padding:2em calc(50% - 457px -  150px);margin:0;box-sizing:border-box}@media screen and (max-width:1274px){html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview{padding:2em}}@media screen and (max-width:450px){html body[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview{width:100%}}html body[for="html-export"]:not([data-presentation-mode]):not([html-show-sidebar-toc]) .markdown-preview{left:50%;transform:translateX(-50%)}html body[for="html-export"]:not([data-presentation-mode]):not([html-show-sidebar-toc]) .md-sidebar-toc{display:none}
/* Please visit the URL below for more information: */
/*   https://shd101wyy.github.io/markdown-preview-enhanced/#/customize-css */
h1 {
  counter-reset: chapter;
}
h2 {
  counter-reset: section;
}
h3 {
  counter-reset: sub-section;
}
h4 {
  counter-reset: sub-sub-section;
}
.markdown-preview.markdown-preview h1 {
  text-align: center;
}
.markdown-preview.markdown-preview h2 {
  border-bottom: 2px solid #ccc;
  padding: 0 0 5px 10px;
}
.markdown-preview.markdown-preview h3 {
  border-bottom: 2px solid #ccc;
  padding: 0 0 5px 10px;
}
.markdown-preview.markdown-preview h4 {
  border-bottom: 2px solid #ccc;
  padding: 0 0 5px 10px;
}
.markdown-preview.markdown-preview h5 {
  padding: 0 0 5px 10px;
}
.markdown-preview.markdown-preview h2::before {
  counter-increment: chapter;
  content: counter(chapter) ". ";
}
.markdown-preview.markdown-preview h3::before {
  counter-increment: section;
  content: counter(chapter) "." counter(section) ". ";
}
.markdown-preview.markdown-preview h4::before {
  counter-increment: sub-section;
  content: counter(chapter) "." counter(section) "." counter(sub-section) ". ";
}
.markdown-preview.markdown-preview .box {
  border: 1px solid #ccc;
  padding: 5px;
  margin-bottom: 20px;
}
.markdown-preview.markdown-preview .toc {
  border: 2px solid #ccc;
  padding: 5px;
}
.markdown-preview.markdown-preview .toc-title {
  font-size: 1.2em;
}
.markdown-preview.markdown-preview .two-image {
  display: flex;
  justify-content: space-around;
}
.center {
  margin: auto 0 auto;
}
  </style>
</head>
<body>
  <div class="mume markdown-preview  ">
    <h1 class="mume-header" id="%E9%A0%86%E7%95%AA%E5%BE%85%E3%81%A1%E3%82%B7%E3%82%B9%E3%83%86%E3%83%A0-%E6%93%8D%E4%BD%9C%E3%83%9E%E3%83%8B%E3%83%A5%E3%82%A2%E3%83%AB">順番待ちシステム 操作マニュアル</h1>
    <p><span class="toc-title"><strong>目次</strong></span></p>
    <div class="toc">
      <ul>
        <li><a href="#%E9%A0%86%E7%95%AA%E5%BE%85%E3%81%A1%E3%82%B7%E3%82%B9%E3%83%86%E3%83%A0-%E6%93%8D%E4%BD%9C%E3%83%9E%E3%83%8B%E3%83%A5%E3%82%A2%E3%83%AB">順番待ちシステム 操作マニュアル</a>
          <ul>
            <li><a href="#%E3%83%9E%E3%83%8B%E3%83%A5%E3%82%A2%E3%83%AB%E3%81%AE%E6%94%B9%E8%A8%82%E5%B1%A5%E6%AD%B4">マニュアルの改訂履歴</a></li>
            <li><a href="#%E6%9C%AC%E3%82%B7%E3%82%B9%E3%83%86%E3%83%A0%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6">本システムについて</a></li>
            <li><a href="#%E5%BA%97%E8%88%97%E5%81%B4%E3%81%8C%E5%88%A9%E7%94%A8%E3%81%99%E3%82%8B%E7%94%BB%E9%9D%A2">店舗側が利用する画面</a>
              <ul>
                <li><a href="#%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%E7%94%BB%E9%9D%A2">ログイン画面</a>
                  <ul>
                    <li><a href="#%E7%AE%A1%E7%90%86%E8%80%85%E7%94%BB%E9%9D%A2%E3%81%B8%E3%81%AE%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%E6%89%8B%E9%A0%86">管理者画面へのログイン手順</a></li>
                    <li><a href="#%E8%87%AA%E5%8B%95%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3">自動ログイン</a></li>
                  </ul>
                </li>
                <li><a href="#%E7%AE%A1%E7%90%86%E8%80%85%E7%94%BB%E9%9D%A2">管理者画面</a>
                  <ul>
                    <li><a href="#%E5%8F%97%E4%BB%98%E7%95%AA%E5%8F%B7%E3%81%AE%E7%99%BA%E8%A1%8C">受付番号の発行</a></li>
                    <li><a href="#%E3%82%AB%E3%83%83%E3%83%88%E4%B8%AD%E3%81%B8%E3%81%AE%E5%A4%89%E6%9B%B4">カット中への変更</a></li>
                    <li><a href="#%E5%91%BC%E3%81%B3%E5%87%BA%E3%81%97%E4%B8%AD%E3%81%B8%E3%81%AE%E5%A4%89%E6%9B%B4">呼び出し中への変更</a></li>
                    <li><a href="#%E5%BE%85%E3%81%A1%E7%95%AA%E5%8F%B7%E3%81%AE%E7%8A%B6%E6%85%8B%E5%A4%89%E6%9B%B4-%E3%81%9D%E3%81%AE%E4%BB%96">待ち番号の状態変更 (その他)</a></li>
                    <li><a href="#%E5%BE%85%E3%81%A1%E7%95%AA%E5%8F%B7%E3%81%AE%E3%83%AA%E3%82%BB%E3%83%83%E3%83%88">待ち番号のリセット</a></li>
                    <li><a href="#%E5%96%B6%E6%A5%AD%E7%B5%82%E4%BA%86">営業終了</a></li>
                    <li><a href="#%E3%82%B7%E3%82%B9%E3%83%86%E3%83%A0%E3%83%AD%E3%82%B0%E3%82%A2%E3%82%A6%E3%83%88">システムログアウト</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#%E9%A1%A7%E5%AE%A2%E5%81%B4%E3%81%8C%E9%96%B2%E8%A6%A7%E3%81%99%E3%82%8B%E7%94%BB%E9%9D%A2">顧客側が閲覧する画面</a>
              <ul>
                <li><a href="#%E9%A0%86%E7%95%AA%E5%BE%85%E3%81%A1%E7%8A%B6%E6%B3%81%E8%A1%A8%E7%A4%BA%E7%94%BB%E9%9D%A2">順番待ち状況表示画面</a>
                  <ul>
                    <li><a href="#%E7%8F%BE%E5%9C%A8%E3%82%AB%E3%83%83%E3%83%88%E4%B8%AD%E3%81%AE%E5%BE%85%E3%81%A1%E7%95%AA%E5%8F%B7%E8%A1%A8%E7%A4%BA">現在カット中の待ち番号表示</a></li>
                    <li><a href="#%E5%BE%85%E3%81%A1%E4%BA%BA%E6%95%B0%E3%82%AB%E3%83%83%E3%83%88%E3%81%BE%E3%81%A7%E3%81%AE%E3%81%8A%E3%81%8A%E3%82%88%E3%81%9D%E3%81%AE%E6%99%82%E9%96%93%E8%A1%A8%E7%A4%BA">待ち人数・カットまでのおおよその時間表示</a></li>
                    <li><a href="#%E5%BE%85%E3%81%A1%E7%95%AA%E5%8F%B7%E4%B8%80%E8%A6%A7%E3%81%AE%E8%A1%A8%E7%A4%BA">待ち番号一覧の表示</a></li>
                    <li><a href="#%E8%A1%A8%E7%A4%BA%E6%83%85%E5%A0%B1%E3%81%AE%E6%9B%B4%E6%96%B0">表示情報の更新</a></li>
                    <li><a href="#%E5%96%B6%E6%A5%AD%E7%B5%82%E4%BA%86%E8%A1%A8%E7%A4%BA">営業終了表示</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <h2 class="mume-header" id="%E3%83%9E%E3%83%8B%E3%83%A5%E3%82%A2%E3%83%AB%E3%81%AE%E6%94%B9%E8%A8%82%E5%B1%A5%E6%AD%B4">マニュアルの改訂履歴</h2>
    <table>
      <thead>
        <tr>
          <th style="text-align:center">更新日付</th>
          <th style="text-align:left">版数</th>
          <th style="text-align:left">更新内容</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="text-align:center">2022/05/05</td>
          <td style="text-align:left">1.0版</td>
          <td style="text-align:left">初版作成</td>
        </tr>
      </tbody>
    </table>
    <h2 class="mume-header" id="%E6%9C%AC%E3%82%B7%E3%82%B9%E3%83%86%E3%83%A0%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6">本システムについて</h2>
    <p>本システムはWeb上で動作する理美容店向けの順番待ち管理システムです。<br> 本システムを使用することで顧客へ現在の順番待ち状況をお知らせすることができます。<br> 本システムは大きく店舗側で使用する「ログイン画面」「管理者画面」と顧客側が閲覧する「順番待ち状況表示画面」に分けられ、3つ画面から構成されます。<br> 以降のセクションで本システムの利用者から見た画面の使用方法を解説します。</p>
    <h2 class="mume-header" id="%E5%BA%97%E8%88%97%E5%81%B4%E3%81%8C%E5%88%A9%E7%94%A8%E3%81%99%E3%82%8B%E7%94%BB%E9%9D%A2">店舗側が利用する画面</h2>
    <p>本セクションでは店舗側で操作する「ログイン画面」「管理者画面」について解説します。</p>
    <h3 class="mume-header" id="%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%E7%94%BB%E9%9D%A2">ログイン画面</h3>
    <p>セキュリティの観点から「管理者画面」は直接表示せずに「ログイン画面」を設けています。<br> 以下のURLをChromeブラウザへ入力することでログイン画面が表示されます。</p>
    <div class="box"> https://cutshop-freestyle-waiting.tk/app/login </div>
    <h4 class="mume-header" id="%E7%AE%A1%E7%90%86%E8%80%85%E7%94%BB%E9%9D%A2%E3%81%B8%E3%81%AE%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%E6%89%8B%E9%A0%86">管理者画面へのログイン手順</h4>
    <p>ブラウザのURL欄(緑色の枠)に指定されたログイン画面のURLを入力しEnterキーを押すと本システムのログイン画面が表示されます。<br> ※本マニュアルで掲載している画像は開発中画面を使用しているため、ブラウザのURL欄に表示されているURLは製品版のものと異なります。</p>
    <p>赤枠で囲った部分に管理者用の UserName と Password を入力して青枠の「Login」ボタンをクリックして下さい。<br> <img src="/images/readme_images/001.png" alt="画像"></p>
    <p>入力されたログイン情報に誤りが無ければ以下のような「管理者画面」が表示されます。<br> <img src="/images/readme_images/002.png" alt="画像"></p>
    <p>入力されたログイン情報に誤りがある場合は以下のような赤枠で囲った通知が表示されます。入力内容をご確認の上再度ログイン操作を実行して下さい。<br> <img src="/images/readme_images/003.png" alt="画像"></p>
    <h4 class="mume-header" id="%E8%87%AA%E5%8B%95%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3">自動ログイン</h4>
    <p>一度ログインし「管理者画面」で「ログアウト」ボタンが押されない場合(ブラウザにログイン情報が残っている場合)は自動ログイン処理が実行され、「管理者画面」が表示されます。</p>
    <p><img src="/images/readme_images/004.png" alt="画像"></p>
    <h3 class="mume-header" id="%E7%AE%A1%E7%90%86%E8%80%85%E7%94%BB%E9%9D%A2">管理者画面</h3>
    <p>本画面は順番待ち状況がどのような状態になっているのか順番待ち状態をコントロールするための画面です。<br> この「管理者画面」で操作した結果が顧客が閲覧する「順番待ち状況表示画面」に反映されます。</p>
    <p>本画面を表示するためには「ログイン画面」での認証が必要となります。<br> ※ログイン状態がキープされている場合は以下のURLをChromeブラウザへ入力することで直接「管理者画面」を表示することも可能です。<br> ※未ログイン状態で以下のURLを入力するとログイン画面へ自動遷移します。<br> ※本画面はパソコン・画面幅が広いタブレットでの操作を想定しています。スマートフォンでの操作は動作対象外です。</p>
    <div class="box"> https://cutshop-freestyle-waiting.tk/app/admin </div>
    <h4 class="mume-header" id="%E5%8F%97%E4%BB%98%E7%95%AA%E5%8F%B7%E3%81%AE%E7%99%BA%E8%A1%8C">受付番号の発行</h4>
    <p>新しく受付番号を追加する場合は赤枠で囲った「受付番号発行ボタン」をクリックします。<br> <img src="/images/readme_images/005.png" alt="画像"></p>
    <p>正常に受付番号発行処理が行われると以下のように「待ち番号」欄に追加されます。<br> <img src="/images/readme_images/006.png" alt="画像"></p>
    <p>※「管理者画面」が上記の場合、順番待ち状況表示画面(顧客側が閲覧する画面)では以下の様に表示されます。<br> ※本画面の詳細については「順番待ち状況表示画面」のセクションをご覧下さい。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/007.png" alt="画像"></p>
      <p><img src="/images/readme_images/008.png" alt="画像"></p>
    </div>
    <h4 class="mume-header" id="%E3%82%AB%E3%83%83%E3%83%88%E4%B8%AD%E3%81%B8%E3%81%AE%E5%A4%89%E6%9B%B4">カット中への変更</h4>
    <p>待ち番号の数字を青枠で囲った部分にドラッグ・アンド・ドロップすることで、対象の番号を&quot;カット中&quot;の状態に変更できます。<br> ※青枠で囲った部分にカット中の番号が登録されていない場合、店舗の状態が自動的に&quot;カット中&quot;の表示へ切り替わります。<br> ※青枠で囲った部分にカット中の番号が登録されている場合、自動で「カット済み」欄へカット中の番号が移動します。</p>
    <p><img src="/images/readme_images/009.png" alt="画像"></p>
    <p>(ドラッグ・アンド・ドロップ後)</p>
    <p><img src="/images/readme_images/010.png" alt="画像"></p>
    <p>※「管理者画面」が上記の場合、順番待ち状況表示画面(顧客側が閲覧する画面)では以下の様に表示されます。<br> ※本画面の詳細については「順番待ち状況表示画面」のセクションをご覧下さい。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/011.png" alt="画像"></p>
      <p><img src="/images/readme_images/012.png" alt="画像"></p>
    </div>
    <h4 class="mume-header" id="%E5%91%BC%E3%81%B3%E5%87%BA%E3%81%97%E4%B8%AD%E3%81%B8%E3%81%AE%E5%A4%89%E6%9B%B4">呼び出し中への変更</h4>
    <p>待ち番号の数字を青枠で囲った部分にドラッグ・アンド・ドロップすることで、対象の番号を&quot;呼び出し中&quot;の状態に変更できます。</p>
    <p><img src="/images/readme_images/013.png" alt="画像"></p>
    <p>(ドラッグ・アンド・ドロップ後)</p>
    <p><img src="/images/readme_images/014.png" alt="画像"></p>
    <p>※「管理者画面」が上記の場合、順番待ち状況表示画面(顧客側が閲覧する画面)では以下の様に表示されます。<br> ※本画面の詳細については「順番待ち状況表示画面」のセクションをご覧下さい。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/015.png" alt="画像"></p>
      <p><img src="/images/readme_images/016.png" alt="画像"></p>
    </div>
    <h4 class="mume-header" id="%E5%BE%85%E3%81%A1%E7%95%AA%E5%8F%B7%E3%81%AE%E7%8A%B6%E6%85%8B%E5%A4%89%E6%9B%B4-%E3%81%9D%E3%81%AE%E4%BB%96">待ち番号の状態変更 (その他)</h4>
    <p>青枠で囲った欄は自由に待ち番号の移動が可能です。<br> 既に解説した2つの方法以外のパターンが生じた場合、待ち番号を自由に移動し状況にあった内容に操作して下さい。<br> ※カット中の番号から他の欄へ番号を移動した場合、待ち番号が「-」に変わり店の状態が準備中の表示となります。</p>
    <p><img src="/images/readme_images/017.png" alt="画像"></p>
    <h4 class="mume-header" id="%E5%BE%85%E3%81%A1%E7%95%AA%E5%8F%B7%E3%81%AE%E3%83%AA%E3%82%BB%E3%83%83%E3%83%88">待ち番号のリセット</h4>
    <p>待ち番号を初期状態に戻す場合は赤枠で囲った「リセットボタン」をクリックします。</p>
    <p><img src="/images/readme_images/018.png" alt="画像"></p>
    <p>「リセットボタン」をクリックすると確認画面が表示されますので「OKボタン」をクリックして下さい。「Cancelボタン」をクリックするとリセット処理が中断されます。</p>
    <p><img src="/images/readme_images/019.png" alt="画像"></p>
    <p>(OKボタンを押した直後)</p>
    <p><img src="/images/readme_images/020.png" alt="画像"></p>
    <p>※「管理者画面」が上記の場合、順番待ち状況表示画面(顧客側が閲覧する画面)では以下の様に表示されます。<br> ※本画面の詳細については「順番待ち状況表示画面」のセクションをご覧下さい。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/021.png" alt="画像"></p>
      <p><img src="/images/readme_images/012.png" alt="画像"></p>
    </div>
    <h4 class="mume-header" id="%E5%96%B6%E6%A5%AD%E7%B5%82%E4%BA%86">営業終了</h4>
    <p>店舗の営業を終了する場合は赤枠で囲った「営業終了ボタン」をクリックして下さい。<br> ※この操作を実行することで各待ち番号が初期状態に戻ります。</p>
    <p><img src="/images/readme_images/022.png" alt="画像"></p>
    <p>「営業終了ボタン」をクリックすると確認画面が表示されますので「OKボタン」をクリックして下さい。「Cancelボタン」をクリックすると営業終了処理が中断されます。</p>
    <p><img src="/images/readme_images/023.png" alt="画像"></p>
    <p>(OKボタンを押した直後)<br> ※営業終了直後に管理画面の表示更新や再読み込みをすると店舗の状態が&quot;準備中&quot;に変わりますのでご注意下さい。&quot;準備中&quot;に変わってしまった場合は再度「営業終了ボタン」をクリックすれば再度&quot;営業終了&quot;状態にすることが可能です。</p>
    <p><img src="/images/readme_images/024.png" alt="画像"></p>
    <p>※「管理者画面」が上記の場合、順番待ち状況表示画面(顧客側が閲覧する画面)では以下の様に表示されます。<br> ※本画面の詳細については「順番待ち状況表示画面」のセクションをご覧下さい。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/025.png" alt="画像"></p>
    </div>
    <h4 class="mume-header" id="%E3%82%B7%E3%82%B9%E3%83%86%E3%83%A0%E3%83%AD%E3%82%B0%E3%82%A2%E3%82%A6%E3%83%88">システムログアウト</h4>
    <p>赤枠で囲った「ログアウトボタン」を押すことで本システムをログアウトします。<br> 営業終了後、本システムを操作しない場合はログアウトされることを推奨します。<br> ※ログアウトしても操作した待ち番号の状態はリセットされません。待ち番号をリセットしたい場合は「リセットボタン」をクリックして下さい。<br> ※ログアウト後に操作を継続する場合は再度ログイン処理を実行して下さい。</p>
    <p><img src="/images/readme_images/026.png" alt="画像"></p>
    <p>ログアウトボタンを押した直後ログイン画面へ移動します。</p>
    <p><img src="/images/readme_images/027.png" alt="画像"></p>
    <h2 class="mume-header" id="%E9%A1%A7%E5%AE%A2%E5%81%B4%E3%81%8C%E9%96%B2%E8%A6%A7%E3%81%99%E3%82%8B%E7%94%BB%E9%9D%A2">顧客側が閲覧する画面</h2>
    <p>本セクションでは顧客側が閲覧する「順番待ち状況表示画面」について解説します。</p>
    <h3 class="mume-header" id="%E9%A0%86%E7%95%AA%E5%BE%85%E3%81%A1%E7%8A%B6%E6%B3%81%E8%A1%A8%E7%A4%BA%E7%94%BB%E9%9D%A2">順番待ち状況表示画面</h3>
    <p>本画面は「管理者画面」で操作した情報を表示する顧客向けの画面です。<br> 店舗で使用する場合は以下のURLを顧客へ周知して下さい。</p>
    <div class="box"> https://cutshop-freestyle-waiting.tk/app/waiting </div>
    <p>また、本画面で閲覧可能な情報は以下の通りです。</p>
    <ul>
      <li>現在カット中の待ち番号</li>
      <li>待ち人数</li>
      <li>カットまでのおおよその時間</li>
      <li>順番待ち番号の一覧 (順番待ち, 呼び出し中)</li>
    </ul>
    <p>※本画面はスマートフォン・タブレット・PCでの閲覧が可能です。<br> ※ガラケーでの表示は動作対象外です。</p>
    <h4 class="mume-header" id="%E7%8F%BE%E5%9C%A8%E3%82%AB%E3%83%83%E3%83%88%E4%B8%AD%E3%81%AE%E5%BE%85%E3%81%A1%E7%95%AA%E5%8F%B7%E8%A1%A8%E7%A4%BA">現在カット中の待ち番号表示</h4>
    <p>「順番待ち状況表示画面」の以下の部分にカット中の待ち番号が表示されます。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/028.png" alt="画像"></p>
    </div>
    <p>「管理者画面」の以下の部分と連動しており、赤枠内上の店舗状態欄・赤枠内下の番号欄で表示されている内容が「順番待ち状況表示画面」に反映されます。</p>
    <p><img src="/images/readme_images/029.png" alt="画像"></p>
    <p>店舗状態と「順番待ち状況表示画面」の関係は以下の通りです。</p>
    <ul>
      <li>店舗状態がカット中の場合 → カット番号を表示</li>
      <li>店舗状態が準備中の場合 → カット番号を「-」として&quot;準備中&quot;の表示</li>
    </ul>
    <h4 class="mume-header" id="%E5%BE%85%E3%81%A1%E4%BA%BA%E6%95%B0%E3%82%AB%E3%83%83%E3%83%88%E3%81%BE%E3%81%A7%E3%81%AE%E3%81%8A%E3%81%8A%E3%82%88%E3%81%9D%E3%81%AE%E6%99%82%E9%96%93%E8%A1%A8%E7%A4%BA">待ち人数・カットまでのおおよその時間表示</h4>
    <p>「順番待ち状況表示画面」の以下の部分に 現在の待ち人数 と カットまでのおおよその時間 が表示されます。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/030.png" alt="画像"></p>
    </div>
    <p>「管理者画面」の以下の部分と連動しており、赤枠内左の待ち番号欄・赤枠内右の呼び出し中番号欄で表示されている内容が「順番待ち状況表示画面」に反映されます。</p>
    <p><img src="/images/readme_images/031.png" alt="画像"></p>
    <p>※待ち人数・待ち時間の表示/計算について</p>
    <div class="box">
      <p> 待ち人数は <b>待ち番号欄の番号数 と 呼び出し中番号欄の番号数 を足した結果</b> が表示されます。<br> 計算例：<b>待ち番号欄の番号数:3 + 呼び出し中番号欄の番号数:1 = 4(人)</b> </p>
      <p> 待ち時間は <b>待ち人数 ✕ 20(分)</b> で計算されます。<br> 計算例：<b>待ち人数:4(人) ✕ 20(分) = 80(分)</b> </p>
    </div>
    <h4 class="mume-header" id="%E5%BE%85%E3%81%A1%E7%95%AA%E5%8F%B7%E4%B8%80%E8%A6%A7%E3%81%AE%E8%A1%A8%E7%A4%BA">待ち番号一覧の表示</h4>
    <p>「順番待ち状況表示画面」の赤枠で囲った「待ち番号の一覧を表示」をクリックすることで待ち番号の一覧が画面左側からスライド表示されます。<br> ※待ち番号の一覧を閉じる場合は左上の「✕ボタン」をクリックして下さい。<br> ※スマートフォンの場合は全画面表示, パソコン・画面幅が大きいタブレットの場合は左側の一部に表示されます。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/032.png" alt="画像"></p>
      <p><img src="/images/readme_images/033.png" alt="画像"></p>
    </div>
    <p>こちらも待ち人数・待ち時間表示と同様に「管理者画面」の以下の部分と連動しており、赤枠内左の待ち番号欄・赤枠内右の呼び出し中番号欄で表示されている内容が「順番待ち状況表示画面」に反映されます。<br> 待ち番号と呼び出し中番号それぞれの表示内容は以下の通りです。</p>
    <ul>
      <li>待ち番号 → 白背景表示</li>
      <li>呼び出し中番号 → 赤背景表示</li>
    </ul>
    <p><img src="/images/readme_images/031.png" alt="画像"></p>
    <h4 class="mume-header" id="%E8%A1%A8%E7%A4%BA%E6%83%85%E5%A0%B1%E3%81%AE%E6%9B%B4%E6%96%B0">表示情報の更新</h4>
    <p>「順番待ち状況表示画面」の赤枠で囲った「最新の情報に更新」をクリックすることで時刻表示がボタンをクリックした時刻に変わり、待ち情報が最新の内容に更新されます。<br> ※サーバの負荷を低減するため、本ボタンがクリックされた直後は5秒経過するまでクリックすることができません。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/034.png" alt="画像"></p>
    </div>
    <h4 class="mume-header" id="%E5%96%B6%E6%A5%AD%E7%B5%82%E4%BA%86%E8%A1%A8%E7%A4%BA">営業終了表示</h4>
    <p>「管理者画面」で「営業終了ボタン」がクリックされ、店舗が営業終了状態になると「順番待ち状況表示画面」は以下の様に表示されます。<br> 店舗の状態が&quot;準備中&quot;もしくは&quot;カット中&quot;になることで通常の表示へ戻ります。<br> ※「最新の情報に更新」をクリックすることにより前述と同じ動作で表示情報を更新します。</p>
    <div class="two-image">
      <p><img src="/images/readme_images/025.png" alt="画像"></p>
    </div>
  </div>
</body>
</html>