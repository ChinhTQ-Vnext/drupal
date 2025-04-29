<?php

use Drupal\taxonomy\Entity\Term;
use Drupal\field\Entity\FieldConfig;
use Drupal\Core\Url;

function bootstrap5_preprocess_pdfdownload_views_view(&$variables)
{
    if ($variables['rows']) {
        $size            = 0;
        $listPdfDownload = [];
        $size            = sizeof($variables['rows'][0]['#rows']);
        foreach ($variables['rows'][0]['#rows'] as &$row) {
            $dataPdf    = [];
            $mediaImage = $row['#node']->get('field_pdf_thumbnail')->entity;
            $image      = $mediaImage->get('field_media_image')->entity;
            $uriImage   = $image->getFileUri();

            $mediaPdf = $row['#node']->get('field_pdf_file')->entity;

            if ($mediaPdf) {
                $file = $mediaPdf->get('field_media_document')->entity; 
                if ($file) {
                    $uriPdf = $file->getFileUri();
                    $namePdf = $file->getFilename();
                }
            }

            $dataPdf['field_pdf_vid']          = $row['#node']->get('vid')->value;
            $dataPdf['field_pdf_title']        = $row['#node']->get('title')->value;
            $dataPdf['field_pdf_name']         = $namePdf;
            $dataPdf['field_pdf_category']     = $row['#node']->get('field_pdf_category')->value;
            $dataPdf['field_pdf_number_page']  = $row['#node']->get('field_pdf_number_page')->value;
            $dataPdf['field_pdf_type']         = $row['#node']->get('field_pdf_type')->value;
            $dataPdf['field_pdf_release_date'] = date('Y-m-d', $row['#node']->get('changed')->value);
            $dataPdf['field_pdf_thumbnail']    = \Drupal::service('file_url_generator')->generateAbsoluteString($uriImage);
            $dataPdf['field_pdf_file']         = \Drupal::service('file_url_generator')->generateAbsoluteString($uriPdf);
            // dd($dataPdf);
            $listPdfDownload[] = $dataPdf;
        }

        $variables['pdfDownload'] = $listPdfDownload;
        $variables['size'] = $size;
    }
}