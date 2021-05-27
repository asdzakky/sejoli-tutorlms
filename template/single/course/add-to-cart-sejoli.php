<?php
    global $post;

    $products = sejolitutor_get_products($post->ID);
?>
<div class="sejoli-product-related product-list">
    <h4 class='title'><?php _e('Kelas ini tersedia pada produk :', 'sejoli'); ?></h4>
    <ul>
    <?php
    foreach($products as $product_id) :
        $product = get_post($product_id);
    ?>
        <li>
            <a href='<?php echo get_permalink($product_id); ?>'>
                <?php echo $product->post_title; ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
