'use strict';
/* пути к исходным файлам (src), к готовым файлам (build), а также к тем, за изменениями которых нужно наблюдать (watch) */
let path = {
  dist: {
    public: 'public/dist/'
  },
  src: {
    public: 'public/src/'
  },
  type: {
    html: '**/[^_]*.+(html|tpl|php)',
    js: '**/[^_]*.js',
    scss: '**/[^_]*.+(sass|scss)',
    css: '**/[^_]*.css',
    img: '**/[^_]*.+(jpg|jpeg|png|svg|gif)'
  },
  watch: {
    html: '**/*.+(html|tpl|php)',
    js: '**/*.js',
    css: '**/*.css',
    scss: '**/[^_]*.+(sass|scss)',
    img: '**/*.(jpg|jpeg|png|svg|gif)'
  }
};

/* подключаем gulp и плагины */
let gulp = require('gulp'),  // подключаем Gulp
  plumber = require('gulp-plumber'), // модуль для отслеживания ошибок
  rigger = require('gulp-rigger'), // модуль для импорта содержимого одного файла в другой
  sourcemaps = require('gulp-sourcemaps'), // модуль для генерации карты исходных файлов
  sass = require('gulp-sass'), // модуль для компиляции SASS (SCSS) в CSS
  autoprefixer = require('gulp-autoprefixer'), // модуль для автоматической установки автопрефиксов
  cleanCSS = require('gulp-clean-css'), // плагин для минимизации CSS
  uglify = require('gulp-uglify'), // модуль для минимизации JavaScript
  cache = require('gulp-cache'), // модуль для кэширования
  rimraf = require('gulp-rimraf'), // плагин для удаления файлов и каталогов,
  babel = require('gulp-babel'), //перевод с новых стандартов js в старые для кроссбраузерности
  htmlmin = require('gulp-htmlmin'), //минификация html
  args = require('yargs').argv, //работа с аргументами
  rename = require('gulp-rename'), //переименование
  wpStream = require('webpack-stream'), //работа с webpack
  imagemin = require('gulp-imagemin'),
  imageminJpegRecompress = require('imagemin-jpeg-recompress'),
  imageminPngquant = require('imagemin-pngquant');

/* параметры */
let key = args.key || 'public';
let modules = args.modules || 'false';
let mode = args.mode || 'development';
let wpFile = args.wpFile || 'main.js';
let wpDistFile = wpFile.replace(/.js$/, '.min.js');

/* конфигурация webpack */
let wpConfig = {
  output: {
    filename: wpDistFile
  },
  mode: mode,
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  },
  devtool: mode == 'development' ? 'eval-sourcemap' : false
}

console.log(key);
// сбор html
gulp.task('html:build', function () {
  return gulp.src(path.src[key] + path.type.html) // выбор всех html файлов по указанному пути
    .pipe(plumber()) // отслеживание ошибок
    .pipe(rigger()) // импорт вложений
    .pipe(htmlmin({
      collapseWhitespace: true, // удаляем все переносы
      removeComments: true // удаляем все комментарии
    }))	
    .pipe(gulp.dest(path.dist[key])) // выкладывание готовых файлов
});

// css компиляция
gulp.task('css:build', function () {
  return gulp.src(path.src[key] + path.type.css) // получим все стили css
    .pipe(plumber()) // для отслеживания ошибок
    .pipe(rename({ suffix: ".min" }))
    .pipe(sourcemaps.init()) // инициализируем sourcemap
    .pipe(autoprefixer({ //префиксы
      overrideBrowserslist: ['last 25 versions'],
      cascade: false
    }))
    .pipe(cleanCSS()) // минимизируем CSS
    .pipe(sourcemaps.write('./')) // записываем sourcemap
    .pipe(gulp.dest(path.dist[key])) // выгружаем в build
});

// scss компиляция
gulp.task('scss:build', function () {
  return gulp.src(path.src[key] + path.type.scss) // получим все стили scss
    .pipe(plumber()) // для отслеживания ошибок
    .pipe(rename({ suffix: ".min" }))
    .pipe(sourcemaps.init()) // инициализируем sourcemap
    .pipe(sass()) // scss -> css
    .pipe(autoprefixer({ //префиксы
      overrideBrowserslist: ['last 25 versions'],
      cascade: false
    }))
    .pipe(cleanCSS()) // минимизируем CSS
    .pipe(sourcemaps.write('./')) // записываем sourcemap
    .pipe(gulp.dest(path.dist[key])) // выгружаем в build
});

// сбор js файла с использованием webpack
gulp.task('js-w:build', function () {
  return gulp.src(path.src[key] + wpFile) // получим файл js
    .pipe(plumber()) // для отслеживания ошибок
    .pipe(rigger()) // импортируем все указанные файлы js
    .pipe(wpStream(wpConfig))
    .pipe(gulp.dest(path.dist[key])) // положим готовый файл
});

// сбор js
gulp.task('js:build', function () {
  return gulp.src(path.src[key] + path.type.js) // получим файлы js
    .pipe(rename({ suffix: ".min" }))
    .pipe(plumber()) // для отслеживания ошибок
    .pipe(rigger()) // импортируем все указанные файлы js
    .pipe(sourcemaps.init()) //инициализируем sourcemap
    .pipe(babel({
      "presets": [
        [
          "@babel/preset-env",
          {
            "modules": modules
          }
        ]
      ]
    }))
    .pipe(uglify()) // минимизируем js	
    .pipe(sourcemaps.write('./')) //  записываем sourcemap
    .pipe(gulp.dest(path.dist[key])) // положим готовый файл
});

// сбор img
gulp.task('img:build', function () {
  return gulp.src(path.src[key] + path.type.img) // получим файлы img
    .pipe(imagemin([
      imagemin.gifsicle({interlaced: true}),
      imageminJpegRecompress({
        progressive: true,
        max: 80,
        min: 70
      }),
      imageminPngquant({quality: [0.7, 0.9]}),
      imagemin.svgo({plugins: [{removeViewBox: true}]})
    ]))
    .pipe(gulp.dest(path.dist[key])) // положим файлы 
});

// удаление js
gulp.task('js:clean', function () {
  return gulp.src(path.dist[key] + path.type.js, { read: false })
    .pipe(rimraf());
});

// удаление js файла с использованием webpack
gulp.task('js-w:clean', function () {
  return gulp.src(path.dist[key] + wpDistFile, { read: false })
    .pipe(rimraf());
});

// удаление img
gulp.task('img:clean', function () {
  return gulp.src(path.dist[key] + path.type.img, { read: false })
    .pipe(rimraf());
});

// удаление html
gulp.task('html:clean', function () {
  return gulp.src(path.dist[key] + path.type.html, { read: false })
    .pipe(rimraf());
});

// удаление css
gulp.task('css:clean', function () {
  return gulp.src(path.dist[key] + path.type.css, { read: false })
    .pipe(rimraf());
});

// удаление scss
gulp.task('scss:clean', function () {
  return gulp.src(path.dist[key] + path.type.scss, { read: false })
    .pipe(rimraf());
});

// удаление стилей
gulp.task('style:clean',
  gulp.series(
    gulp.parallel(
      'css:clean',
      'scss:clean'
    )
  )
);

// удаление каталога dist 
gulp.task('clean', function () {
  return gulp.src(path.dist[key] + '*', { read: false })
    .pipe(rimraf());
});

// сборка стилей
gulp.task('style:build',
  gulp.series(
    gulp.parallel(
      'css:build',
      'scss:build'
    )
  )
);

// сборка всего
gulp.task('build',
  gulp.series('clean',
    gulp.parallel(
      'style:build',
      'js:build',
      'html:build',
      'img:build'
    )
  )
);

// запуск задач при изменении файлов
gulp.task('watch', function () {
  gulp.watch(path.src[key] + path.watch.css, gulp.series('css:build'));
  gulp.watch(path.src[key] + path.watch.scss, gulp.series('scss:build'));
  gulp.watch(path.src[key] + path.watch.js, gulp.series('js:build'));
  gulp.watch(path.src[key] + path.watch.html, gulp.series('html:build'));
  gulp.watch(path.src[key] + path.watch.img, gulp.series('img:build'));
});

// очистка кэша
gulp.task('cache:clear', async function () {
  cache.clearAll();
});