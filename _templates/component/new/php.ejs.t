---
to: components/<%= h.changeCase.paramCase(name) %>/<%= h.changeCase.paramCase(name) %>.php
---
<?php
/**
* <%= name %>
* -----------------------------------------------------------------------------
*
* <%= name %> component
*/

$classes = $component_args['classes'] ?? [];
$component_id = $component_args['id'] ?? false;
$defaults = [
];

$component_data = parse_args( $component_data, $defaults );
?>

<?php if ( is_empty( $component_data ) ) return; ?>
<section class="<%= h.changeCase.paramCase(name) %> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="<%= h.changeCase.paramCase(name) %>">

</section>
