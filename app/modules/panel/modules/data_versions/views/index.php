<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">

                <!-- Head -->
                <div class="flex-btw flex-vc mob_fc">
                    <h1>Data Versions</h1>
                </div>

                <!-- Filters -->
                <div class="flex-start flex-wrap">
                    <div>
                        <label for="module">Module (table)</label>
                        <select class="form-control" name="module" id="module" onchange="load('panel/data_versions/filter', 'module#module');">
                            <option value="">All</option>
                            <?php if ($this->modules) { ?>
                                <?php foreach ($this->modules as $item) { ?>
                                    <option value="<?= $item ?>"><?= $item ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive mb-4 mt-4" id="filter_result">
                    <?php include _SYSDIR_ . 'modules/panel/modules/data_versions/views/filter.php' ?>
                </div>

            </div>
        </div>

    </div>
</div>
