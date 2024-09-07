<?php

namespace controllers;

use models\StudentAdmissionModel;

use core\db\MySQL;
use core\helpers\Constants;

class StudentAdmissionController
{
    private $studentAdmissionModel;
    public function __construct()
    {
        $this->studentAdmissionModel = new StudentAdmissionModel(new MySQL());
    }

    public function setStudentAdmissions($data)
    {
        return $this->studentAdmissionModel->setStudentAdmissions(Constants::$STUDENT_TBL, $data);
    }
    // old student admission
    public function setOldStudentAdmissions($id, $data, $files)
    {
        return $this->studentAdmissionModel->setOldStudentAdmissions($id, $data, $files);
    }

    // for credit transfer students status=2
    public function setStudentAdmissionsByStatus($data)
    {
        return $this->studentAdmissionModel->setStudentAdmissionsByStatus(Constants::$STUDENT_TBL, $data);
    }
    public function getAllStudentsByStatusAndYear($status, $year, $academicYear, $page, $limit)
    {
        return $this->studentAdmissionModel->getAllStudentsByStatusAndYear(Constants::$STUDENT_TBL, $status, $year, $academicYear, $page, $limit);
    }
    public function getAllStudentsEmailByStatus($status)
    {
        return $this->studentAdmissionModel->getAllStudentsEmailByStatus(Constants::$STUDENT_TBL, $status);
    }
    public function getStudentById($status)
    {
        return $this->studentAdmissionModel->getStudentById($status);
    }
    public function getTotalRows($year, $status)
    {
        return $this->studentAdmissionModel->getTotalRows(Constants::$STUDENT_TBL, $year, $status);
    }
    public function approveFresher($data)
    {
        return $this->studentAdmissionModel->approveFresher(Constants::$STUDENT_TBL, Constants::$STUDENT_AUTH_TBL, $data);
    }
    public function approveOldStudent($data)
    {
        return $this->studentAdmissionModel->approveOldStudent(Constants::$STUDENT_TBL, $data);
    }

    public function getStudentsYear()
    {
        return $this->studentAdmissionModel->getStudentsYear(Constants::$STUDENT_TBL);
    }

    public function getApprovedStudentsYear()
    {
        return $this->studentAdmissionModel->getApprovedStudentsYear(Constants::$STUDENT_TBL);
    }

    public function getStudentAdmissionTotalCount($studentYear)
    {
        return $this->studentAdmissionModel->getStudentAdmissionTotalCount(Constants::$STUDENT_TBL, $studentYear);
    }

    public function getStudentAdmissionApprovedCount($studentYear)
    {
        return $this->studentAdmissionModel->getStudentAdmissionApprovedCount(Constants::$STUDENT_TBL, $studentYear);
    }

    public function getStudentAdmissionTotalCountByStatus($status)
    {
        return $this->studentAdmissionModel->getStudentAdmissionTotalCountByStatus(Constants::$STUDENT_TBL, $status);
    }

    public function getApprovedStudentsRollNum($studentYear)
    {
        return $this->studentAdmissionModel->getApprovedStudentsRollNum(Constants::$STUDENT_TBL, $studentYear);
    }

    public function getStudentNameAndRollNumAndSemesterAndSectionPaginationData($page, $limit, $semester, $section)
    {
        return $this->studentAdmissionModel->getStudentNameAndRollNumAndSemesterAndSectionPaginationData($page, $limit, $semester, $section);
    }

    public function getStudentIdBetweenRollNum($startRollNum, $endRollNum)
    {
        return $this->studentAdmissionModel->getStudentIdBetweenRollNum(Constants::$STUDENT_TBL, $startRollNum, $endRollNum);
    }

    public function setStudentSection($studentData)
    {
        return $this->studentAdmissionModel->setStudentSection(Constants::$STUDENT_SECTION_TBL, $studentData);
    }
}
