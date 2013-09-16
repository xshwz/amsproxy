<?php
/**
 *  魔术控制器
 */
class MagicController extends StudentController {
    public static $specialized = array(
        '高等数学AI',
        '大学物理AⅠ',
        '高等数学A2',
        'C语言A',
        '电路基础A',
        '汇编语言程序设计',
        '数字电路A',
        '计算机组成与体系结构',
        '单片机原理与应用B',
        '计算机网络A',
        '通信原理B',
        'TCP/IP原理与应用',
        '操作系统',
    );

	public function actionIndex() {
        $scoreTable = $this->getScore(1);
        $this->render('index', array(
            'specialized' => $this->getSpecialized($scoreTable),
        ));
	}

    public function getSpecialized($scoreTable) {
        foreach ($scoreTable['tbody'] as $termScore) {
            foreach ($termScore as $scoreItem) {
                $scoreName = preg_replace('/\[.*?\]/', '', $scoreItem[0]);
                if (in_array($scoreName, self::$specialized)) {
                    $specialized[$scoreName] = array(
                        'score' => $scoreItem[6],
                        'credit' => $scoreItem[1],
                    );
                }
            }
        }
        $specialized['数据结构'] = array(
            'score' => null,
            'credit' => 3.5,
        );
        return $specialized;
    }
}
