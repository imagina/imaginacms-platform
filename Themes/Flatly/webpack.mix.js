const mix = require('laravel-mix');
const WebpackShellPlugin = require('webpack-shell-plugin');
const WebpackMildCompile = require('webpack-mild-compile').Plugin;
const themeInfo = require('./theme.json');

mix.webpackConfig({
  watchOptions: {
    //Not working. ignored: ['/node_modules/','./resources/scss/modules/']
  },
  plugins: [
    new WebpackMildCompile(), // See: https://github.com/webpack/watchpack/issues/25.
    new WebpackShellPlugin({onBuildEnd: ['php ../../artisan stylist:publish ' + themeInfo.name]})
  ]
});

const themePublicRelPath = 'themes/'+ themeInfo.name.toLowerCase();
mix.setPublicPath('../../public/');

//Import File Helpers
const { readdirSync, statSync } = require('fs');
const { join } = require('path');
const fs = require('fs');

//Function to get dirs recursive
const dirs = p => readdirSync(p).filter(f => statSync(join(p, f)).isDirectory());

//Let's get all the modules installed
const modules = dirs('../../Modules/');

let jsfilestomerge = [];
let scssfilestomerge = [];

// reordering of modules leaving Isite first
modules.sort(function(x,y){ return x == "Isite" ? -1 : y == "Isite" ? 1 : 0; });
modules.forEach(function(mname) {
  let pfile = '../../Modules/'+mname+'/Resources/views/vue/components.js';
  if(fs.existsSync(pfile)) {
    jsfilestomerge.push(pfile);
  }

  let scssfile = '../../Modules/'+mname+'/Resources/scss/main.scss';
  if(fs.existsSync(scssfile)) {

    /**
     *  Copy scss directory to the module
     */
    let scssModuleThemePath = './resources/scss/modules/'+mname.toLowerCase()+'/main.scss';
    scssfilestomerge.push(scssModuleThemePath);

    let scssPath = '../../Modules/'+mname+'/Resources/scss/';
    mix.copy(
      scssPath,
      './resources/scss/modules/'+mname.toLowerCase()
    );
  }

  /**
   * Copy Modules Source Resources
   */
  let path = '../../Modules/'+mname+'/Resources/views/vue/components/'

  if(fs.existsSync(path)) {
    mix.copy(
      path,
      './resources/js/components/'+mname.toLowerCase()
    );
  }
});

/*
Overwrite files from components
 */
mix.copy(
  'overwrites/',
  './'
);

/**
 * Concat scripts
 */
mix.scripts([
  'node_modules/popper.js/dist/umd/popper.min.js',
  'node_modules/bootstrap/dist/js/bootstrap.min.js',
  'node_modules/owl.carousel/dist/owl.carousel.min.js',
  'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js'
], 'assets/js/secondary.js')
  .scripts([
    'resources/js/app.js',
    'resources/js/imagina.js',
    ...jsfilestomerge,
  ], 'resources/js/main.js');



/**
 * Merge main.scss of each module at the bottom of secondary.scss
 */
mix.combine([...scssfilestomerge], 'resources/scss/_modules-combined.scss');

/**
 * Compile sass
 */
mix.sass('resources/scss/main.scss', themePublicRelPath+'/css/app.css')
    .sass('resources/scss/secondary.scss', themePublicRelPath+'/css/secondary.css');



mix.js(['resources/js/main.js'], themePublicRelPath+'/js/app.js');


mix.browserSync({
  //logLevel: 'debug',
  /*files: [
    mix.config.publicPath+'/'+themePublicRelPath+'/css/app.css',
    mix.config.publicPath+'/'+themePublicRelPath+'/css/secondary.css',
    mix.config.publicPath+'/'+themePublicRelPath+'/js/app.js'
  ],*/
  proxy: 'localhost',
  https: true
});
