<td class="wrapper">
    <p>The following person has completed the website contact form</p>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:14px; color:#636363; font-family: Tahoma,sans-serif;">
        <?php if (post('name')) { ?>
            <tr>
                <td width="40%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><strong>Name</strong></td>
                <td width="60%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><?= trim(post('name')); ?></td>
            </tr>
        <?php } ?>
        <?php if (post('email')) { ?>
            <tr>
                <td width="40%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><strong>Email</strong></td>
                <td width="60%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><?= post('email'); ?></td>
            </tr>
        <?php } ?>
        <?php if (post('tel')) { ?>
            <tr>
                <td width="40%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><strong>Phone</strong></td>
                <td width="60%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><?= post('tel'); ?></td>
            </tr>
        <?php } ?>
        <?php if (post('location')) { ?>
            <tr>
                <td width="40%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><strong>Location</strong></td>
                <td width="60%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><?= post('location'); ?></td>
            </tr>
        <?php } ?>
        <?php if (post('message')) { ?>
            <tr>
                <td width="40%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><strong>Message</strong></td>
                <td width="60%" style="padding: 10px; border-bottom: 1px solid #cccccc;"><?= str_replace('\r\n', '<br>', post('message')); ?></td>
            </tr>
        <?php } ?>
    </table>
</td>