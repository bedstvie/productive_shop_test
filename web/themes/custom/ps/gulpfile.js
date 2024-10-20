const { src, dest, watch, series, parallel } = require("gulp");
const sourcemaps = require("gulp-sourcemaps");
const sassGlob = require("gulp-sass-glob");
const sass = require('gulp-sass')(require('sass'));
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const minifycss = require("gulp-clean-css");
const eslint = require("gulp-eslint");
const gulpIf = require("gulp-if");
const gulpStylelint = require("gulp-stylelint");
const babel = require("gulp-babel");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");

// File paths
const files = {
  stylesPath: "scss/*.scss",
  jsPaths: ["src/js/*.js"]
};

// Sass task: compiles the style.scss file into style.css
function stylesTask() {
  return src(files.stylesPath)
    .pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
    .pipe(postcss([autoprefixer({remove: false}), cssnano()]))
    .pipe(sourcemaps.write("."))
    .pipe(minifycss())
    .pipe(dest("css"));
}

// TODO use this for
function isFixed(file) {
  return file.eslint != null && file.eslint.fixed;
}

// Apply Eslint on all js files.
function eslintTask() {
  const _fix = process.argv.includes("--fix");

  return src(files.jsPaths)
    .pipe(eslint({ fix: _fix }))
    .pipe(eslint.formatEach())
    .pipe(eslint.failAfterError());
}

// Lint all styles files.
function scsslintTask() {
  return src([files.stylesPath]).pipe(
    gulpStylelint({
      reporters: [
        {
          formatter: "string",
          console: true
        }
      ]
    })
  );
}

function jsTask() {
  return src(files.jsPaths)
    .pipe(
      babel({
        presets: ["@babel/preset-env"]
      })
    )
    .pipe(uglify())
    .pipe(rename({ suffix: ".min" }))
    .pipe(dest("js"));
}

// Watch task: watch SCSS and JS files for changes
// If any change, run scss and js tasks simultaneously
function watchTask() {
  watch(
    files.jsPaths.concat(files.stylesPath),
    series(parallel(stylesTask, jsTask))
  );
}

// Export the default Gulp task so it can be run
// Runs the scss and js tasks simultaneously
exports.default = series(parallel(stylesTask, jsTask), watchTask);

exports.styles = parallel(stylesTask, jsTask);
exports.lintjs = series(eslintTask);
exports.lintscss = series(scsslintTask);
