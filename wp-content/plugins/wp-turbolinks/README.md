# wp-turbolinks

[Turbolinks](https://github.com/rails/turbolinks/) extracted from Rails, for use with WordPress. Turbolinks uses JavaScript to follow links, so the browser doesn't have to download and process JavaScript and CSS files again. In other words, it should make your site faster. From the project page:

> Turbolinks makes following links in your web application faster. Instead of
> letting the browser recompile the JavaScript and CSS between each page change, it
> keeps the current page instance alive and replaces only the body and the title in
> the head. Think CGI vs persistent process.

Want to know more? See the [Turbolinks project page](https://github.com/rails/turbolinks/) for implementation details, compatibility caveats, and more information.

Also includes [jquery.turbolinks](https://github.com/kossnocorp/jquery.turbolinks) for jQuery support.

The idea is to just enable the plugin and make your blog faster. Sites with heavy JavaScript may have some problems, and is not necessarily recommended. There are documented workarounds and fixes for popular JavaScript libraries located at the [Turbolinks Compatibility project](http://reed.github.io/turbolinks-compatibility/).

There are probably a lot of bugs. Please report them!

# Hacking

```
$ npm install
$ grunt watch
```
