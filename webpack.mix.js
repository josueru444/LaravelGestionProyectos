const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .babelConfig({
       plugins: ['@babel/plugin-proposal-class-properties']
   })
   .webpackConfig({
       module: {
           rules: [
               {
                   test: /\.m?js$/,
                   exclude: /(node_modules|bower_components)/,
                   use: {
                       loader: 'babel-loader',
                       options: {
                           presets: ['@babel/preset-env'],
                           plugins: ['@babel/plugin-proposal-class-properties']
                       }
                   }
               }
           ]
       }
   });
