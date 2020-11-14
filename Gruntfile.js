"use strict";
module.exports = function (grunt) {
  // Load all tasks
  require("load-grunt-tasks")(grunt);
  // Show elapsed time
  require("time-grunt")(grunt);

  var jsFileList = [
    "assets/vendor/bootstrap/js/dropdown.js",
    "assets/vendor/bootstrap/js/collapse.js",
    "assets/vendor/bootstrap/js/transition.js",
    "assets/js/plugins/*.js",
    "assets/js/_*.js",
  ];

  grunt.initConfig({
    sass: {
      dev: {
        files: {
          "assets/css/main.css": "assets/stylesheets/main.scss",
        },
        options: {
          style: "expanded",
          sourcemap: "inline",
        },
      },
      build: {
        files: {
          "assets/css/main.min.css": "assets/stylesheets/main.scss",
        },
        options: {
          style: "compressed",
        },
      },
    },
    concat: {
      options: {
        separator: ";",
      },
      dist: {
        src: [jsFileList],
        dest: "assets/js/scripts.js",
      },
    },
    autoprefixer: {
      options: {
        browsers: [
          "last 2 versions",
          "ie 8",
          "ie 9",
          "android 2.3",
          "android 4",
          "opera 12",
        ],
      },
      dev: {
        options: {
          map: {
            prev: "assets/css/",
          },
        },
        src: "assets/css/main.css",
      },
      build: {
        src: "assets/css/main.min.css",
      },
    },
    modernizr: {
      build: {
        devFile: "assets/js/vendor/modernizr.min.js",
        outputFile: "assets/js/vendor/modernizr.min.js",
        files: {
          src: [["assets/js/scripts.min.js"], ["assets/css/main.min.css"]],
        },
        extra: {
          shiv: false,
        },
        uglify: true,
        parseFiles: true,
      },
    },
    version: {
      default: {
        options: {
          format: true,
          length: 32,
          manifest: "assets/manifest.json",
          querystring: {
            style: "roots_css",
            script: "roots_js",
          },
        },
        files: {
          "lib/scripts.php": "assets/{css,js}/{main,scripts}.min.{css,js}",
        },
      },
    },
    watch: {
      sass: {
        files: ["assets/stylesheets/*.scss", "assets/stylesheets/**/*.scss"],
        tasks: ["sass:dev", "autoprefixer:dev"],
      },
      livereload: {
        // Browser live reloading
        // https://github.com/gruntjs/grunt-contrib-watch#live-reloading
        options: {
          livereload: true,
        },
        files: [
          "assets/css/main.css",
          "assets/js/scripts.js",
          "templates/**/*.php",
          "trive-events/*.php",
          "*.php",
        ],
      },
    },
  });

  // Register tasks
  grunt.registerTask("default", ["dev"]);
  grunt.registerTask("dev", ["sass:dev", "autoprefixer:dev", "concat"]);
  grunt.registerTask("build", [
    "sass:build",
    "autoprefixer:build",
    "modernizr",
    "version",
  ]);
};
