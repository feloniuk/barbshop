import gulp from 'gulp';
import { plugins } from './config/gulp-plugins.js';
import { path } from './config/gulp-settings.js';

import { stylesMain, stylesAdmin } from './config/gulp-tasks/styles.js';
import { serve, serveAdmin } from './config/gulp-tasks/_serve.js';

global.app = {
    gulp: gulp,
    path: path,
    plugins: plugins,
};

const devTasks = gulp.series(stylesMain, stylesAdmin, serve);

const buildTasks = gulp.series(stylesMain, stylesAdmin);

const adminTasks = gulp.series(stylesAdmin, serveAdmin);

const dev = gulp.series(devTasks);

let build = gulp.series(buildTasks);

let admin = gulp.series(adminTasks);

export { dev };
export { build };
export { admin };
