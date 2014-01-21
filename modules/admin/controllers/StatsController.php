<?php
class StatsController extends AdminController {
    public function actionIndex() {
        $stats = array(
            'gender' => array(
                '男' => 0,
                '女' => 0,
            ),
            'college' => array(),
            'grade' => array(),
            'nation' => array(),
        );

        /** 使用Dao取代ar,因为ar->findAll一次占用内存过多 */
        $reader = Student::getDaoRaeder();
        while (($student = $reader->read()) !== false) {
            $archives = (array)json_decode($student['archives']);
            $college = $archives['院(系)/部'];
            $discipline = $archives['专业'];
            $grade = $archives['入学年份'];
            $nation = isset($archives['民族']) ? $archives['民族'] : null;

            $stats['gender'][$archives['性别']]++;

            /** 年级统计 */
            if (array_key_exists($grade, $stats['grade']))
                $stats['grade'][$grade]++;
            else
                $stats['grade'][$grade] = 1;

            /** 民族统计 */
            if ($nation) {
                if (array_key_exists($nation, $stats['nation']))
                    $stats['nation'][$nation]++;
                else
                    $stats['nation'][$nation] = 1;
            }

            /** 学院、专业，统计 */
            if (array_key_exists($college, $stats['college'])) {
                $stats['college'][$college]['count']++;
                if (array_key_exists(
                    $discipline, $stats['college'][$college]['discipline'])) {

                        $stats['college'][$college]['discipline'][$discipline]++;
                    } else {
                        $stats['college'][$college]['discipline'][$discipline] = 0;
                    }
            } else {
                $stats['college'][$college] = array(
                    'count' => 1,
                    'discipline' => array(),
                );
            }
        }

        $this->render('index', array(
            'stats' => $stats,
        ));
    }
}
