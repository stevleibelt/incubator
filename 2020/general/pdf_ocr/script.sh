#!/bin/bash
####
# @author stev leibelt <artodeto@bazzline.net>
# @since 2017-12-26
####

SOURCE="${1}"

SOURCE_AS_TIFF="${SOURCE}.tiff"

echo ":: Converting source to a tiff file."
convert -density 300 "${SOURCE}" -depth 8 "${SOURCE_AS_TIFF}"

echo ":: Using tesseract to ocr the file."
tesseract -l deu "${SOURCE_AS_TIFF}" "${SOURCE}"

echo ":: Removing tiff file."
rm "${SOURCE_AS_TIFF}"
echo "   Text file ${SOURCE}.txt generated."
