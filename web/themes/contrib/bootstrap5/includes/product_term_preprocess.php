<?php

use Drupal\taxonomy\Entity\Term;
use Drupal\field\Entity\FieldConfig;
use Drupal\Core\Url;

function bootstrap5_preprocess_product_term_views_view(&$variables)
{
    $term_id = $variables['view_array']['#arguments'][0];
    $term = Term::load($term_id);
    $uri = $term->field_url->uri;
    $term_url = Url::fromUri($uri)->toString();
    $title = $term ? $term->label() : "";

    // load field_product_area
    $field_config = FieldConfig::loadByName('node', 'product', 'field_product_area');
    $options = $field_config->getSetting('allowed_values');

    $group_products = [];
    $product_area_data = [];
    $parent_term = null;
    $child_terms = [];
    if (sizeof($variables['rows']) > 0) {
        foreach ($variables['rows'] as &$row) {
            $group = [];
            $product_area = "";
            foreach ($row['#rows'] as $product) {
                $entity = $product['#row']->_entity;
                $entity->url_redirect = $term_url . "/" . $entity->get('field_slug')->value;
                $field_category = $entity->get('field_category')->referencedEntities();
                $parent_ids = $term->get('parent')->getValue();
                if (!empty($parent_ids)) {

                    $parent_tid = $parent_ids[0]['target_id'];
                    $parent_term = Term::load($parent_tid);
                    // remake url
                    $url = $term->field_url->uri;
                    $parent_term_url = $term->url_redirect = Url::fromUri($url)->toString();
                    $parent_term->parent_term_url = $parent_term_url;

                    $child_terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties([
                        'parent' => $parent_tid,
                    ]);

                    foreach ($child_terms as $child_term) {
                        // remake url
                        $url = $child_term->field_url->uri;
                        $child_term_url = $term->url_redirect = Url::fromUri($url)->toString();
                        $child_term->child_term_url = $child_term_url;
                    }
                }
                if ($field_category) {
                    $title =  $field_category[0]->label();
                }
                if (!$product_area) {
                    $key = $entity->get('field_product_area')->value;
                    $product_area = $options[$key];
                    $group["product_area_key"] = $key;
                    $group["product_area_label"] = $product_area;
                    $product_area_data[$key] = $product_area;
                }

                $group['products'][] =  $entity;
            }
            $group_products[] = $group;
            $product_area = "";
            $group = [];
        }
    }
    $variables['product_area_data'] = $product_area_data;
    $variables['group_products'] = $group_products;
    $variables['view_array']['#title']['#markup'] = $title;
    $variables['title'] = $title;
    $variables['parent_term'] = $parent_term;
    $variables['child_terms'] = $child_terms;
}

function bootstrap5_preprocess_category_views_view(&$variables)
{
    $title = "";
    $terms = [];
    if ($variables['rows']) {
        $category = $variables['rows'][0]['#rows'][0]['#row']->_entity;
        $parent_tid = $category->id();
        $title = $category->label();
        $child_tids = \Drupal::entityQuery('taxonomy_term')
            ->condition('parent', $parent_tid)
            ->condition('vid', 'product_category')
            ->accessCheck(FALSE)
            ->execute();
        $child_terms = Term::loadMultiple($child_tids);
        foreach ($child_terms as $term) {
            $uri = $term->field_url->uri;
            $term->url_redirect = Url::fromUri($uri)->toString();
        }
        $terms['parent'] = $category;
        $terms['childs'] = $child_terms;
    }

    $variables['view_array']['#title']['#markup'] = $title;
    $variables['title'] = $title;
    $variables['terms'] = $terms;
}

function bootstrap5_preprocess_product_detail_views_view(&$variables)
{
    $title = "";
    $product = null;
    if ($variables['rows']) {
        $product = $variables['rows'][0]['#rows'][0]['#row']->_entity;
        $title = $product->get('field_product_name')->value;
    }

    $variables['view_array']['#title']['#markup'] = $title;
    $variables['title'] = $title;
    $variables['product'] = $product;
}

function bootstrap5_preprocess_product_spec_views_view(&$variables)
{
    $title = "";
    $product = null;
    if ($variables['product_spec']) {
        $product = $variables['product_spec']->get('field_product')->entity;
        $title = $product->get('field_product_name')->value;
    }

    $variables['view_array']['#title']['#markup'] = $title;
    $variables['title'] = $title;
}

function bootstrap5_preprocess_home_views_view(&$variables)
{
    $variables['view_array']['#title']['#markup'] = "アイ・オー・データ機器";
    $datas = $variables['rows'][0]['#rows'];
    $carousels = [];
    $pick_ups = [];
    foreach ($datas as $item) {
        if (isset($item['#node']) && $item['#node'] instanceof \Drupal\node\NodeInterface) {
            $node = $item['#node'];
            if ($node->id() == 8) {
                if ($node->hasField('field_carousel') && !$node->get('field_carousel')->isEmpty()) {
                    foreach ($node->get('field_carousel')->referencedEntities() as $paragraph) {
                        $carousel = [];
                        $uri = $paragraph->field_url->uri;
                        $carousel['url'] = Url::fromUri($uri)->toString();
                        $image = $paragraph->get('field_image')->entity;
                        $carousel['image'] = $image;
                        $carousels[] = $carousel;
                    }
                }

                if ($node->hasField('field_carousel') && !$node->get('field_carousel')->isEmpty()) {
                    foreach ($node->get('field_pick_up')->referencedEntities() as $paragraph) {
                        $pick_up = [];
                        $uri = $paragraph->field_href->uri;
                        $pick_up['url'] = Url::fromUri($uri)->toString();
                        $image = $paragraph->get('field_pickup')->entity;
                        $pick_up['image'] = $image;
                        $pick_ups[] = $pick_up;
                    }
                }
            }
        }
    }
    $variables['carousels'] = $carousels;
    $variables['pick_ups'] = $pick_ups;
}
