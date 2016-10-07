<?php
/**
 * This script initiates a video conference session, calling the BigBlueButton API
 * @package chamilo.plugin.bigbluebutton
 */

use Chamilo\UserBundle\Entity\User;

$course_plugin = 'bbb'; //needed in order to load the plugin lang variables
$cidReset = true;

require_once __DIR__ . '/../../main/inc/global.inc.php';

api_protect_admin_script();

$plugin = BBBPlugin::create();
$tool_name = $plugin->get_lang('Videoconference');
$tpl = new Template($tool_name);

$bbb = new bbb('', '');
$action = isset($_GET['action']) ? $_GET['action'] : null;

$meetings = $bbb->getMeetings(0, 0, 0, true);

foreach ($meetings as &$meeting) {
    $participants = $bbb->findMeetingParticipants($meeting['id']);

    /** @var User $participant */
    foreach ($participants as $participant) {
        $meeting['participants'][] = $participant['participant']->getCompleteName();
    }
}

if ($action) {
    switch ($action) {
        case 'export':
            $dataToExport = [
                [$tool_name, get_lang('RecordList')],
                [],
                [
                    get_lang('CreatedAt'),
                    get_lang('Status'),
                    get_lang('Records'),
                    get_lang('Course'),
                    get_lang('Session'),
                    get_lang('Participants'),
                ]
            ];

            foreach ($meetings as $meeting) {
                $dataToExport[] = [
                    $meeting['created_at'],
                    $meeting['status'] == 1 ? get_lang('MeetingOpened') : get_lang('MeetingClosed'),
                    $meeting['record'] == 1 ? get_lang('Yes') : get_lang('No'),
                    $meeting['course'] ? $meeting['course']->getTitle() : '-',
                    $meeting['session'] ? $meeting['session']->getName() : '-',
                    isset($meeting['participants']) ? implode(PHP_EOL, $meeting['participants']) : null
                ];
            }

            Export::arrayToXls($dataToExport);
            break;
    }
}

if (!empty($meetings)) {
    $meetings = array_reverse($meetings);
}

if (!$bbb->isServerRunning()) {
    Display::addFlash(
        Display::return_message(get_lang('ServerIsNotRunning'), 'error')
    );
}

$tpl->assign('meetings', $meetings);

$content = $tpl->fetch('bbb/admin.tpl');
$actions = [];

if ($meetings) {
    $actions[] = Display::toolbarButton(
        get_lang('ExportInExcel'),
        api_get_self() . '?action=export',
        'file-excel-o',
        'success'
    );
}

$tpl->assign('header', get_lang('RecordList'));
$tpl->assign('actions', implode('', $actions));
$tpl->assign('content', $content);
$tpl->display_one_col_template();