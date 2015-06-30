module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    coffee: {
      compile: {
        files: {
          'js/wp-turbolinks.js': 'js/src/wp-turbolinks.js.coffee',
          'js/jquery.turbolinks.js': 'js/src/jquery.turbolinks.js.coffee'
        }
      }
    },
    uglify: {
      dist: {
        files: {
          'js/wp-turbolinks.min.js': ['js/wp-turbolinks.js'],
          'js/jquery.turbolinks.min.js': ['js/jquery.turbolinks.js']
        }
      }
    },
    watch: {
      files: ['js/src/*.js.coffee'],
      tasks: ['coffee', 'uglify']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['watch']);

};
