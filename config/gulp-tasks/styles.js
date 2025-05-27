import postcss from 'gulp-postcss';
import pcssImport from 'postcss-import';
import pcssImportGlob from 'postcss-import-ext-glob';
import pcssMixins from 'postcss-mixins';
import nested from 'postcss-nested';
import pcssShort from 'postcss-short';
import pcssPresetEnv from 'postcss-preset-env';
import cqPolyfill from 'cq-prolyfill/postcss-plugin.js';
import pcssAutoprefixer from 'autoprefixer';
import pcssFunctions from 'postcss-functions';
import pcssReporter from 'postcss-reporter';
import pcssCustomProperties from 'postcss-custom-properties';
import rename from 'gulp-rename';
import postcssColor from 'postcss-color-mod-function';
import postcssExtend from 'postcss-extend';
import pcssShortNativeVars from 'postcss-short-native-vars';
import sourcemaps from 'gulp-sourcemaps';
import pcssComment from 'postcss-comment';
import cssnano from 'cssnano';

import through2 from 'through2';

import {
  ac,
  rc,
  perc,
  vw,
  setTransition,
} from '../../src/styles/.functions/pcss-functions.js';
import { reportFormatter } from '../gulp-settings.js';

const plugins = [
  pcssImportGlob,
  pcssImport,
  pcssMixins,
  postcssExtend,
  pcssShortNativeVars,
  pcssFunctions({
    functions: { ac, rc, perc, vw, setTransition },
  }),
  pcssCustomProperties,
  postcssColor,
  pcssShort,
  nested,
  pcssPresetEnv(),
  pcssAutoprefixer,
  cqPolyfill,
    cssnano({
        convertValues: {
            length: false,
        },
        discardComments: {
            removeAll: true,
        },
    }),
    pcssReporter({
        clearReportedMessages: true,
        formatter: reportFormatter,
    }),
];

export function stylesMain() {
  return app.gulp
    .src(`${app.path.src.styles.main}`)
    .pipe(sourcemaps.init())
    .pipe(postcss(plugins))
    .pipe(
      rename({
        extname: '.css',
      })
    )
    .pipe(sourcemaps.write('.'))
    .pipe(app.gulp.dest(`${app.path.build.styles.main}`));
}

export function stylesAdmin() {
  return app.gulp
      .src(`${app.path.src.styles.admin}`)
      .pipe(sourcemaps.init())
      .pipe(postcss(plugins))
      .pipe(
          rename({
            extname: '.css',
          })
      )
      .pipe(sourcemaps.write('.'))
      .pipe(app.gulp.dest(`${app.path.build.styles.admin}`));
}
