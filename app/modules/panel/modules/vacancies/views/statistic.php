<link href="<?= _SITEDIR_ ?>public/css/modules-widgets.css" rel="stylesheet" type="text/css">
<script src="<?= _SITEDIR_ ?>public/js/backend/clipboard.min.js" type="text/javascript"></script>

<form id="form_box" action="{URL:panel/vacancies/edit/<?= $this->vacancy->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-top">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-briefcase" href="{URL:panel/vacancies}"></a>
                                    <h1 class="page_title"><?= $this->vacancy->title ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block">
                                    <a href="{URL:job/<?= $this->vacancy->slug; ?>}" class="btn-rectangle bs-tooltip fa fa-eye" title="View Job" target="_blank"></a>

                                    <div class="social-btns-list">
                                        <a onclick="share_linkedin(this);" class="btn-social" href="#" data-url="{URL:job/<?= $this->vacancy->slug; ?>}">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                        <a onclick="share_facebook(this);" class="btn-social" href="#" data-url="{URL:job/<?= $this->vacancy->slug; ?>}">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                        <a onclick="share_twitter(this);" class="btn-social" href="#" data-url="{URL:job/<?= $this->vacancy->slug; ?>}">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a class="btn-social copy_btn" href="#" data-clipboard-text="{URL:job/<?= $this->vacancy->slug; ?>}">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    </div>
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/vacancies}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>

                        <div class="items_group items_group-wrap items_group-bottom">
                            <div class="items_left-side">
                                <div class="option-btns-list scroll-list">
                                    <a href="{URL:panel/vacancies/edit/<?= $this->vacancy->id; ?>}" class="btn btn-rectangle_medium"><i class="bs-tooltip fa fa-pencil-alt"></i>Edit</a>
                                    <a href="{URL:panel/vacancies/applications/<?= $this->vacancy->id; ?>}" class="btn btn-rectangle_medium" title="Applications List"><i class="bs-tooltip far fa-user"></i>Applications</a>
                                    <a class="btn btn-rectangle_medium active" title="Statistic"><i class="bs-tooltip fa fa-chart-bar"></i>Statistic</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Views -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding: 0;">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">

                    <div class="widget-two">
                        <div class="widget-content">

                            <div class="w-numeric-value">
                                <div class="w-content">
                                    <span class="w-value">Views</span>
                                    <span class="w-numeric-title">Source: Website</span>
                                </div>
                            </div>

                            <div class="widget_mm">
                                <div class="w-chart">
                                    <div class="w-chart-section-2">
                                        <div class="w-detail">
                                            <a class="w-title">Total views</a>
                                            <p class="w-stats"><?= defaultValue($this->count, 0); ?></p>
                                        </div>
                                        <div class="w-chart-render-one">
                                            <div id="total_users_1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Referrals -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">

                    <div class="flex-btw flex-vc mob_fc">
                        <h4>Referrals: </h4>
                        <div>
                            <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/vacancies/add_ref/<?= $this->vacancy->id; ?>}">
                                <i class="fas fa-plus"></i>
                                Add <span class="hide_block768">New Referral</span>
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive mb-4 mt-4">
                        <table id="zero-config" class="table table-hover" style="width:100%; overflow: auto;">
                            <thead>
                            <tr>
                                <th>title</th>
                                <th>link</th>
                                <th>views</th>
                                <th class="w_options">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($this->referrals) && is_array($this->referrals) && count($this->referrals)) { ?>
                                <?php foreach ($this->referrals as $item) { ?>
                                    <tr>
                                        <td>
                                            <?= $item->title; ?>
                                        </td>
                                        <td>
                                            <div class="btn btn-copy btn-info" data-link="<?= SITE_URL ?>job/<?= $this->vacancy->slug; ?>?ref=<?= $item->title; ?>" onclick="copyClipboard(this);">copy link</div>
                                        </td>
                                        <td>
                                            <?= $this->refArray[$item->title] ?: 0 ?>
                                        </td>
                                        <td class="option__buttons">
                                           <a href="{URL:panel/vacancies/delete_ref/<?= $item->id; ?>}" class="bs-tooltip fa fa-trash" title="Delete"></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Viewers -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">

                    <div class="flex-btw flex-vc mob_fc">
                        <h4>Viewers: <?= defaultValue($this->count, 0); ?></h4>
                    </div>

                    <div class="table-responsive mb-4 mt-4">
                        <table id="zero-config" class="table table-hover" style="width:100%; overflow-y: auto;">
                            <thead>
                            <tr>
                                <th>Ip</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($this->list) && is_array($this->list) && count($this->list)) { ?>
                                <?php foreach ($this->list as $item) { ?>
                                    <tr>
                                        <td>
                                            <?= $item->ip, $item->ref ? " (" . $item->ref . ")" : ""; ?>
                                        </td>
                                        <td data-sort="<?= $item->time; ?>">
                                            <?= printTime($item->time, 'd-m-Y / H:i'); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</form>

<script src="<?= _SITEDIR_ ?>public/plugins/apex/apexcharts.min.js"></script>
<script>
    $(document).ready(function($) {
        try {
            // Total Visits
            var spark1 = {
                chart: {
                    id: 'total_users_1',
                    group: 'sparks1',
                    type: 'line',
                    height: 100,
                    sparkline: {
                        enabled: true
                    },
                    dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 1,
                        blur: 3,
                        color: '#009688',
                        opacity: 0.6,
                    }
                },
                series: [{
                    data: [<?php
                        $setArr = [];
                        foreach ($this->data as $key => $v) {
                            $setArr[] = '{x: "'.$key.'", y: '.$v.'}';
                        }
                        echo implode(', ', $setArr);
                        ?>]
                    <?php /*data: [<?= implode(', ', $this->list->data) ?>]*/ ?>
                }],
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                markers: {
                    size: 0
                },
                grid: {
                    padding: {
                        top: 35,
                        bottom: 0,
                        left: 40
                    }
                },
                colors: ['#009688'],
                tooltip: {
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function(value, opts) {
                                return (
                                    opts.w.config.series[opts.seriesIndex].data[opts.dataPointIndex].x
                                )
                            }
                        }
                    }
                },
                responsive: [{
                    breakpoint: 1351,
                    options: {
                        chart: {
                            height: 95,
                        },
                        grid: {
                            padding: {
                                top: 35,
                                bottom: 0,
                                left: 0
                            }
                        },
                    },
                },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: {
                                height: 80,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40
                                }
                            },
                        },
                    },
                    {
                        breakpoint: 576,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 0
                                }
                            },
                        },
                    }
                ]
            }

            // Total Visits
            crt_1 = new ApexCharts(document.querySelector("#total_users_1"), spark1);
            crt_1.render();
        } catch (e) {
            // statements
            console.log(e);
        }
    });
</script>

<!-- Connect editor -->
<script>
    var text = '';
    function copyClipboard(el) {
        text = $(el).attr('data-link');
    }

    var clipboard = new Clipboard('.btn-copy', {
        text: function() { return text; }
    });

    clipboard.on('success', function(e) {
        noticeSuccess('Copied');
        e.clearSelection();
    });
</script>