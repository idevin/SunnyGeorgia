const cabinet = require('./webpack-cabinet');
const homepage = require('./webpack-homepage');
const excursion = require('./webpack-excursion');
const excursionsList = require('./webpack-excursions-list');
const tour = require('./webpack-tour');
const toursList = require('./webpack-tours-list');
const place = require('./webpack-place');
const informationPages = require('./webpack-information-pages');

module.exports = [
  cabinet,
  homepage,
  excursion,
  excursionsList,
  tour,
  toursList,
  place,
  informationPages,
];
