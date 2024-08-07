module.exports = function(grunt) {
  grunt.initConfig({
    sass: {
      options: {
        implementation: require('sass'), // Use Dart Sass (the current primary Sass implementation)
        sourceMap: true
      },
      dist: {
        files: {
          'dist/css/theme.css': 'src/sass/theme.scss'
        }
      }
    },
    watch: {
      css: {
        files: 'src/sass/**/*.scss',
        tasks: ['sass'],
      },
    },
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['sass', 'watch']);
};
