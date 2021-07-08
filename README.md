# ARIA Example

This is an example of embedding aria web app.

**Note:** this example requires a web server. Modern browsers have security
features preventing a local web page from accessing other local files, so if you
open `index.html` by double-clicking in your file browser it probably won't be
able to read the `.rive` files the bot needs.


If Python installed run `python -m SimpleHTTPServer` from the root
of the ARIA project.

## Usage: Hosted on an External Server

To upload this example to an external server such as Apache, you'll need to
change a couple of paths around:

1. Upload all the contents to your server.

The directory structure on your web server should look like this:

```
/brain
    /admin.rive
    /begin.rive
    /...
/chat.css
/chat.html
/datadumper.js
/jquery-1.7.2.min.js
/rivescript.js
```

And the top of `Chat` page (line 9) should look like:

```html
<script type="text/javascript" src="rivescript.js"></script>
```
