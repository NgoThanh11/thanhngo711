<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <?php if (!empty($listProduct)): ?>
            <?php foreach ($listProduct as $key => $product): ?>
                <li><?php echo htmlspecialchars($product['ten_san_pham']); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No products found</li>
        <?php endif; ?>
    </ul>
</body>
</html>
