<table class="catalog-listing ecard">
  <thead>
    <tr>
      <th>Price <span class="sort"><?php print $sort['price']['asc']; ?></span> <span class="sort"><?php print $sort['price']['desc']; ?></span></th>
      <th>Ecard</th>
      <th>Category <span class="sort"><?php print $sort['category']['asc']; ?></span> <span class="sort"><?php print $sort['category']['desc']; ?></span></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ( $rows as $row ): ?>
    <?php print $row; ?>
  <?php endforeach; ?>
  </tbody>
</table>