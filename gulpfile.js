/**
 * Gulp task config file.
 */

'use strict';

var pkg     = require( './package.json' ),
    gulp    = require( 'gulp' ),
    globs   = require( 'gulp-src-ordered-globs' ),
    toolkit = require( 'gulp-wp-toolkit' ),
    zip     = require( 'gulp-zip' );

toolkit.extendConfig(
    {
        theme: {
            name: pkg.theme.name,
            themeuri: pkg.theme.uri,
            description: pkg.description,
            author: pkg.author,
            authoruri: pkg.theme.authoruri,
            version: pkg.version,
            license: pkg.license,
            licenseuri: pkg.theme.licenseuri,
            tags: pkg.theme.tags,
            textdomain: pkg.theme.textdomain,
            domainpath: pkg.theme.domainpath,
            template: pkg.theme.template,
            notes: pkg.theme.notes
        },
        src: {
            php: ['**/*.php', '!includes/tgmpa.php'],
            images: 'assets/images/**/*',
            scss: 'assets/styles/*.scss',
            css: ['**/*.css', '!node_modules/**'],
            js: ['assets/scripts/**/*.js', '!node_modules/**'],
            json: ['**/*.json', '!node_modules/**'],
            i18n: './assets/languages/',
            zip: [
                './**/*',
                '!./*.zip',
                '!./git',
                '!./git/**/*',
                '!./node_modules',
                '!./node_modules/**/*'
            ]
        },
        css: {
            basefontsize: 10, // Used by postcss-pxtorem.
            remmediaquery: false,
            scss: {
                'style': {
                    src: 'assets/styles/style.scss',
                    dest: './',
                    outputStyle: 'expanded'
                }
            }
        },
        dest: {
            i18npo: './assets/languages/',
            i18nmo: './assets/languages/',
            images: './assets/images/',
            js: './assets/scripts/'
        },
        server: {
            proxy: 'https://minimal.test',
            host: 'minimal.test',
            open: 'external',
            port: '8000',
            https: {
                'key': '/Users/seothemes/.valet/Certificates/minimal.test.key',
                'cert': '/Users/seothemes/.valet/Certificates/minimal.test.crt'
            }
        }
    }
);

toolkit.extendTasks( gulp, {
    'zip': function() {
        return globs(toolkit.config.src.zip, {base: './'}).
        pipe(zip(pkg.name + '-' + pkg.version + '.zip')).
        pipe(gulp.dest('../'));
    }
} );