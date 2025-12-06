<div class="row fade-in">
    <div class="col-md-12">
        <h2 class="mb-4">Categories</h2>
        
        <div class="mb-4">
            <a href="/admin/categories/create" class="btn-admin">
                <i class="fa fa-plus me-1"></i> Add New Category
            </a>
        </div>
        
        <?php if (empty($categories)): ?>
            <div class="alert alert-info">
                <p>No categories found.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr class="hover-lift">
                                <td><?= $category['id'] ?></td>
                                <td><?= $category['name'] ?></td>
                                <td><?= $category['slug'] ?></td>
                                <td><?= $category['description'] ?? 'No description' ?></td>
                                <td>
                                    <a href="/admin/categories/<?= $category['id'] ?>/edit" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="/admin/categories/<?= $category['id'] ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>