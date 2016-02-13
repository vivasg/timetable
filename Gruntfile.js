module.exports = function (grunt)
{

// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON("package.json"),
		copy: {
			bower: {
				files: [
					{
						flatten: true,
						expand: true,
						filter: "isFile",
						src: "./bower_components/bootstrap/fonts/*",
						dest: "./public/media/fonts"
					},
					{
						src: "./bower_components/angular/angular.js",
						dest: "./public/media/js/angular.js"
					},
					{
						src: "./bower_components/angular-drag-and-drop-lists/angular-drag-and-drop-lists.js",
						dest: "./public/media/js/angular-drag-and-drop-lists.js"
					}
				]
			}
		},
		less: {
			development: {
				options: {
					paths: ["./public/media/css"],
					dumpLineNumbers: "all",
					sourceMap: true,
					sourceMapFileInline: true
				},
				files: {
					"./public/media/css/style.css": "./public/media/css/style.less"
				}
			},
			release: {
				options: {
					paths: ["./public/media/css"],
					compress: true
				},
				files: {
					"./public/media/css/style.css": "./public/media/css/style.less"
				}
			}
		},
		watch: {
			less: {
				files: "./public/media/css/*.less",
				tasks: ["less:development"]
			}
		},
		clean: {
			cleanup: [
				"./apps/cache/*",
				"./apps/logs/*",
				"./public/content/.quarantine",
				"./public/content/.tmb"
			]
		},
		cssmin: {
			release: {
				files: {
					"./public/media/css/style.css": ["./public/media/css/style.css"]
				}
			}
		}
	});

	// Default task(s).
	grunt.loadNpmTasks("grunt-contrib-less");
	grunt.loadNpmTasks("grunt-contrib-cssmin");
	grunt.loadNpmTasks("grunt-contrib-watch");
	grunt.loadNpmTasks("grunt-contrib-clean");
	grunt.loadNpmTasks("grunt-contrib-copy");
	grunt.loadNpmTasks("grunt-string-replace");


	grunt.registerTask("default", ["copy:bower", "less:development", "clean:cleanup"]);
	grunt.registerTask("release", ["copy:bower", "less:release", "cssmin:release", "clean:cleanup"]);
};
