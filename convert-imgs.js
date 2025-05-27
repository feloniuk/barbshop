"use strict";

import fs from "fs";
import webp from "webp-converter";

const IMG_DIR = "./src/images";

function getFiles(dir, files_) {
	files_ = files_ || [];
	var files = fs.readdirSync(dir);
	for (var i in files) {
		var name = dir + "/" + files[i];
		if (fs.statSync(name).isDirectory()) {
			getFiles(name, files_);
		} else {
			if (
				name.search(".png") != -1 ||
				name.search(".jpg") != -1 ||
				name.search(".jpeg") != -1
			) {
				const webpFile = name.replace(/(png|jpg|jpeg)/, "webp");
				webp.cwebp(name, webpFile, "-q 100");
				files_.push(name);
				console.log(`${webpFile} was generated!`);
			}
		}
	}
	return files_;
}

console.log("\x1b[32m WEBP converting started... \x1b[0m");

getFiles(IMG_DIR);

console.log("\x1b[32m WEBP converting finished! \x1b[0m");
