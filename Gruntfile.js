/* jshint node:true */
module.exports = function( grunt ) {
	'use strict';

	grunt.initConfig({

		pkg: grunt.file.readJSON( 'package.json' ),

		// Setting folder templates.
		dirs: {
			js: 'js',
			css: 'css',
			sass: 'sass',
			images: 'images'
		},

		// Other options.
		options: {
			text_domain: 'wpnepal-blog'
		},

		// Generate POT files.
		makepot: {
			target: {
				options: {
					type: 'wp-theme',
					domainPath: 'languages',
					exclude: ['deploy/.*', 'node_modules/.*'],
					updateTimestamp: false,
					potHeaders: {
						'report-msgid-bugs-to': 'https://github.com/wpnepal/wpnepal-blog/issues',
						'x-poedit-keywordslist': true,
						'language-team': '',
						'Language': 'en_US',
						'X-Poedit-SearchPath-0': '../../<%= pkg.name %>',
						'plural-forms': 'nplurals=2; plural=(n != 1);',
						'Last-Translator': 'WP Nepal <wpnepalgroup@gmail.com>'
					}
				}
			}
		},

		// Check textdomain errors.
		checktextdomain: {
			options: {
				text_domain: '<%= options.text_domain %>',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src: [
					'**/*.php',
					'!node_modules/**',
					'!deploy/**'
				],
				expand: true
			}
		},

		// Update text domain.
		addtextdomain: {
			options: {
				textdomain: '<%= options.text_domain %>',
				updateDomains: true
			},
			target: {
				files: {
					src: [
					'*.php',
					'**/*.php',
					'!node_modules/**',
					'!deploy/**',
					'!tests/**'
					]
				}
			}
		},

		// CSS minification.
		cssmin: {
			target: {
				files: [{
					expand: true,
					cwd: '<%= dirs.css %>',
					src: ['*.css', '!*.min.css'],
					dest: '<%= dirs.css %>',
					ext: '.min.css'
				}]
			}
		},

		// Image minification.
		imagemin: {
			png: {
				options: {
					optimizationLevel: 3
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.images %>',
					src: ['*.png'],
					dest: '<%= dirs.images %>'
				}]
			},
			jpg: {
				options: {
					progressive: true
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.images %>',
					src: ['*.jpg'],
					dest: '<%= dirs.images %>'
				}]
			}
		},

		// Copy files to deploy.
		copy: {
			deploy: {
				src: [
					'**',
					'!.*',
					'!*.md',
					'!.*/**',
					'!tmp/**',
					'!Gruntfile.js',
					'!test.php',
					'!package.json',
					'!node_modules/**',
					'!languages/**',
					'!sass/**',
					'!docs/**'
				],
				dest: 'deploy/<%= pkg.name %>',
				expand: true,
				dot: true
			}
		},

		// Clean the directory.
		clean: {
			deploy: ['deploy']
		},

		sass: {
			dev: {
				options: {
					sourcemap: 'none',
					style: 'expanded',
					lineNumbers: true
				},
				files: {
					'style.css': 'sass/style.scss'
				}
			},
			build: {
				options: {
					sourcemap: 'none',
					style: 'expanded'
				},
				files: {
					'style.css': 'sass/style.scss'
				}
			}
		},
		watch: {
			css: {
				files: ['sass/**/*.scss'],
				tasks: ['sass:dev'],
				options: {
					spawn: false
				}
			},
			js: {
				files: ['js/*.js'],
				tasks: ['uglify'],
				options: {
					spawn: false
				}
			}
		},

		// JS check.
		jshint: {
			options: grunt.file.readJSON( '.jshintrc' ),
			all: [
				'Gruntfile.js',
				'js/*.js',
				'!js/*.min.js'
			]
		},

		// Uglify JS.
		uglify: {
			target: {
				options: {
					mangle: true
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.js %>',
					src: ['*.js', '!*.min.js'],
					dest: '<%= dirs.js %>',
					ext: '.min.js'
				}]
			}
		}
	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-imagemin' );

	// Register tasks
	grunt.registerTask( 'default', [
		'watch'
	]);

	grunt.registerTask( 'precommit', [
		'jshint',
		'checktextdomain'
	]);

	grunt.registerTask( 'build', [
		'cssmin',
		'imagemin',
		'uglify',
		'sass:build',
		'addtextdomain',
		'makepot'
	]);

	grunt.registerTask( 'textdomain', [
		'addtextdomain',
		'makepot'
	]);

	grunt.registerTask( 'deploy', [
		'clean:deploy',
		'copy:deploy'
	]);

};
