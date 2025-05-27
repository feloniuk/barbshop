import { stylesMain, stylesAdmin } from "./styles.js";

export function serve() {
  // PostCSS Watcher
  app.gulp
    .watch(
      [`${app.path.src.styles.allExceptAdmin}`,
          `${app.path.src.styles.allRootExceptAdmin}`],
      app.gulp.series(stylesMain)
    )

  app.gulp
      .watch(
          [`${app.path.src.styles.adminOnly}`, `${app.path.src.styles.admin}`],
          app.gulp.series(stylesAdmin)
      )
}

export function serveAdmin() {
  app.gulp
      .watch(
          [`${app.path.src.styles.adminOnly}`, `${app.path.src.styles.admin}`],
          app.gulp.series(stylesAdmin)
      )
}
