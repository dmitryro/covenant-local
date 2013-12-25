<table class="catalog-listing">
  <thead>
    <tr>
      <th>Price <span class="sort"><?php print $sort['price']['asc']; ?></span> <span class="sort"><?php print $sort['price']['desc']; ?></span></th>
      <th>Item</th>
      <th>Program <span class="sort"><?php print $sort['program']['asc']; ?></span> <span class="sort"><?php print $sort['program']['desc']; ?></span></th>
      <th>Quantity</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ( $rows as $row ): ?>
    <?php print $row; ?>
  <?php endforeach; ?>
  </tbody>
</table>