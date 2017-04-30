module.exports = function(grunt) {


  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),
  
    sass: {
      options: {
        sourceMap: true,
      },
      dev: {
        files: {
          'public/styles/<%= pkg.name %>.css': 'src/sass/style.scss',
        },
      },
    },

    notify: {
      sass: {
        options: {
          title: 'Sass',
          message: 'Sassed!',
        },
      },
    },

    autoprefixer: {
      css: {
        src: 'public/styles/<%= pkg.name %>.css',
        options: {
          browsers: [
            '> 1%',
            'last 2 versions',
            'Firefox ESR',
            'iOS >= 7',
            'ie >= 10'
          ],
        },
      },
    },

    watch: {
      sass: {
        files: ['src/sass/**/*.scss'],
        tasks: ['sass:dev', 'notify:sass', 'autoprefixer:css' ],
      },
    },

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-notify');
  grunt.loadNpmTasks("grunt-autoprefixer");
  grunt.registerTask('compile-sass', ['sass:dev', 'notify:sass']);
  grunt.registerTask('default', ['watch']);
};
