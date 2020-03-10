
<?php
/**
 * Changes Past Event Reverse Chronological Order
 *
 * @param array $template_vars An array of variables used to display the current view.
 *
 * @return array Same as above.
 */
function tribe_past_reverse_chronological_v2($template_vars)
{

  if (!empty($template_vars['is_past'])) {
    $template_vars['events'] = array_reverse($template_vars['events']);
  }

  return $template_vars;
}
// Change List View to Past Event Reverse Chronological Order
add_filter('tribe_events_views_v2_view_list_template_vars', 'tribe_past_reverse_chronological_v2', 100);
// Change Photo View to Past Event Reverse Chronological Order
add_filter('tribe_events_views_v2_view_photo_template_vars', 'tribe_past_reverse_chronological_v2', 100);
