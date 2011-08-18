<?php

require_once 'PHPUnit/Framework.php';
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

class CandidateDaoTest extends PHPUnit_Framework_TestCase {

    private $candidateDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->candidateDao = new CandidateDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmRecruitmentPlugin/test/fixtures/CandidateDao.yml';
        TestDataService::populate($this->fixture);
    }

    /**
     * Testing getCandidateById
     */
    public function testGetCandidateById() {

        $this->assertTrue($this->candidateDao->getCandidateById(1) instanceof JobCandidate);
    }

    /**
     * Testing  getAllCandidatesList
     */
    public function testCandidateList() {

	$allowedCandidatesList = array(1,2,3);
        $candidatesList = $this->candidateDao->getCandidateList($allowedCandidatesList);
        $this->assertTrue($candidatesList[0] instanceof JobCandidate);
    }

//    /**
//     * Testing  getCandidateList when only jobTitle is provided
//     */
//    public function testGetCandidateListForJobTitleTest() {
//
//
//        $searchParam = new CandidateSearchParameters();
//
//        $searchParam->setJobTitleCode('JOB001');
//        $searchParam->setCandidateId(1);
//        $searchParam->setVacancyId(1);
//
//
//        $allCandidateVacancyList = TestDataService::loadObjectList('JobCandidateVacancy', $this->fixture, 'JobCandidateVacancy');
//
////        $expectedArray[0] = array('vacancyName' => 'SE 2011', 'candidateName' => 'Yasitha Pandi', 'hiringManager' => 'Kayla Abbey', 'dateOfApplication' => '2011-06-03', 'status' => 'Shortlisted');
//
//        $expectedCandidateVacancyList = array();
//
//        foreach ($allCandidateVacancyList as $candidateVacancy) {
//
//            if ($searchParam->getJobTitleCode() == $candidateVacancy->getJobVacancy()->getJobTitleCode() && $searchParam->getCandidateId() == $candidateVacancy->getJobCandidate()->getId() && $searchParam->getVacancyId() == $candidateVacancy->getJobVacancy()->getId()) {
//                $candidateVacancy->getJobCandidate();
//                $expectedCandidateVacancyList[] = $candidateVacancy;
//            }
//        }
//
//        $expected = $this->extractResultsToArray($expectedCandidateVacancyList);
//
//        $returnedCandidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
//
//        $actual = $this->extractResultsToArray($returnedCandidateVacancyList);
//        $this->assertEquals($actual, $expected);
//    }

    private function extractResultsToArray($candidateVacancyList) {
        $stateMachine = new WorkflowStateMachine();
        $i = 0;
        foreach ($candidateVacancyList as $candidateVacancy) {
            $list[$i]['vacancyName'] = $candidateVacancy->getJobVacancy()->getName();
            $list[$i]['candidateName'] = $candidateVacancy->getJobCandidate()->getFullName();
            $list[$i]['hiringManager'] = $candidateVacancy->getJobVacancy()->getEmployee()->getFullName();
            $list[$i]['dateOfApplication'] = $candidateVacancy->getJobCandidate()->getDateOfApplication();
            $list[$i]['status'] = $stateMachine->getRecruitmentApplicationStateNames($candidateVacancy->getStatus());
            $i++;
        }
        return $list;
    }

    /**
     * Testing  getCandidateList when jobTitle and keywords are provided
     */
    public function testGetCandidateListForJobTitleAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when only vacancyId is provided
     */
    public function testGetCandidateListForVacncy() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setVacancyId(1);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when vacancyId and keywords are provided
     */
    public function testGetCandidateListForVacncyAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setVacancyId(1);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when only Hiring Manager is provided
     */
    public function testGetCandidateListForHiringManager() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setHiringManagerId(1);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when Hiring Manager and keywords are provided
     */
    public function testGetCandidateListForHiringManagerAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setHiringManagerId(1);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when Candidate name is provided
     */
    public function testGetCandidateListForCandidate() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setCandidateId(1);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when Candidate name and keywords are provided
     */
    public function testGetCandidateListForCandidateAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setCandidateId(1);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when only keywords are provided
     */
    public function testGetCandidateListForKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when both jobTitle and vacancyId is provided
     */
    public function testGetCandidateListForJobTitleAndVacancy() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setVacancyId(2);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when both jobTitle,vacancyId and Keywords are provided
     */
    public function testGetCandidateListForJobTitleVacancyAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setVacancyId(2);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when both jobTitle and Hiring manager is provided
     */
    public function testGetCandidateListForJobTitleAndHiringManager() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setHiringManagerId(2);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when both jobTitle, Hiring manager and keywords are provided
     */
    public function testGetCandidateListForJobTitleHiringManagerAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setHiringManagerId(2);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when both Vacancy and Hiring manager is provided
     */
    public function testGetCandidateListForVacancyAndHiringManager() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setVacancyId(1);
        $searchParam->setHiringManagerId(1);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when JobTilte, Vacancy and Hiring manager is provided
     */
    public function testGetCandidateListForJobTitleVacancyAndHiringManager() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setVacancyId(2);
        $searchParam->setHiringManagerId(2);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when JobTilte, Vacancy, Hiring manager and Candidate name is provided
     */
    public function testGetCandidateListForJobTitleVacancyHiringManagerAndCandidate() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setVacancyId(2);
        $searchParam->setHiringManagerId(2);
        $searchParam->setCandidateId(2);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when JobTilte, Vacancy, Hiring manager, Candidate name and keywords are provided
     */
    public function testGetCandidateListForJobTitleVacancyHiringManagerCandidateAndKewords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setVacancyId(2);
        $searchParam->setHiringManagerId(2);
        $searchParam->setCandidateId(2);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when JobTilte, Vacancy, Hiring manager and Candidate name is provided
     */
    public function testGetCandidateListForJobTitleHiringManagerAndCandidate() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setHiringManagerId(2);
        $searchParam->setCandidateId(2);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when JobTilte, Vacancy, Hiring manager, Candidate name and keywords are provided
     */
    public function testGetCandidateListForJobTitleHiringManagerCandidateAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setHiringManagerId(2);
        $searchParam->setCandidateId(2);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when JobTilte and Candidate name is provided
     */
    public function testGetCandidateListForJobTitleAndCandidate() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setCandidateId(1);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when JobTilte, Candidate name and Keywords are provided
     */
    public function testGetCandidateListForJobTitleCandidateAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setJobTitleCode('JOB002');
        $searchParam->setCandidateId(1);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when Vacancy and Candidate name is provided
     */
    public function testGetCandidateListForVacancyAndCandidate() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setVacancyId(1);
        $searchParam->setCandidateId(1);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when Vacancy, Candidate name and Keywords are provided
     */
    public function testGetCandidateListForVacancyCandidateAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setVacancyId(1);
        $searchParam->setCandidateId(1);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when Hiring manager and Candidate name is provided
     */
    public function testGetCandidateListForHiringManagerAndCandidate() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setHiringManagerId(1);
        $searchParam->setCandidateId(1);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when status is provided
     */
    public function testGetCandidateListForStatus() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setStatus("REJECTED");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when mode of application is provided
     */
    public function testGetCandidateListForModeOfApplication() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setModeOfApplication(1);

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    /**
     * Testing  getCandidateList when Hiring manager, Candidate name and keywords are provided
     */
    public function testGetCandidateListForHiringManagerCandidateAndKeywords() {

        $searchParam = new CandidateSearchParameters();
        $searchParam->setHiringManagerId(1);
        $searchParam->setCandidateId(1);
        $searchParam->setKeywords("java,oracle");

        $candidateVacancyList = $this->candidateDao->searchCandidates($this->candidateDao->buildSearchQuery($searchParam));
        $this->assertTrue($candidateVacancyList[0] instanceof CandidateSearchParameters);
    }

    public function testSaveCandidate() {

        $candidate = new JobCandidate();
        $candidate->id = 20;
        $candidate->firstName = "Yasitha";
        $candidate->middleName = "Chathuranga";
        $candidate->lastName = "Pandithawatta";
        $candidate->email = "yasitha@gmail.com";
        $candidate->comment = "ok";
        $candidate->contactNumber = "0777777777";
        $candidate->keywords = "php,java";
        $candidate->dateOfApplication = "2011-07-04";
        $candidate->status = 1;
        $candidate->modeOfApplication = 1;



        $this->candidateDao->saveCandidate($candidate);
        $this->assertNotNull($candidate->getId());
    }

    public function testSaveCandidateForNullId() {

        $candidate = new JobCandidate();
        $candidate->id = null;
        $candidate->firstName = "Yasitha";
        $candidate->middleName = "Chathuranga";
        $candidate->lastName = "Pandithawatta";
        $candidate->email = "yasitha@gmail.com";
        $candidate->comment = "ok";
        $candidate->contactNumber = "0777777777";
        $candidate->keywords = "php,java";
        $candidate->dateOfApplication = "2011-07-04";
        $candidate->status = 1;
        $candidate->modeOfApplication = 1;

        $return = $this->candidateDao->saveCandidate($candidate);
        $this->assertTrue($return);
    }

    /**
     * 
     */
    public function testSaveCandidateVacancy() {

        $candidateVacancy = new JobCandidateVacancy();
        $candidateVacancy->candidateId = 1;
        $candidateVacancy->vacancyId = 2;
        $candidateVacancy->status = 0;
        $candidateVacancy->appliedDate = '2011-07-08';

        $this->candidateDao->saveCandidateVacancy($candidateVacancy);
        $candidateVacancy = TestDataService::fetchObject('JobCandidateVacancy', array(1, 2));
        $this->assertEquals($candidateVacancy->getStatus(), 0);
        $this->assertEquals($candidateVacancy->getAppliedDate(), '2011-07-08');
    }

    public function testGetCandidateVacancyById() {
        $this->assertTrue($this->candidateDao->getCandidateVacancyById(3) instanceof JobCandidateVacancy);
    }

    public function testUpdateCandidateVacancy() {

        $candidateVacancyList = TestDataService::loadObjectList('JobCandidateVacancy', $this->fixture, 'JobCandidateVacancy');
        $candidateVacancyList[1]->status = 'REJECTED';
        $result = $this->candidateDao->updateCandidateVacancy($candidateVacancyList[1]);
        $this->assertEquals($result, 1);
    }

    public function testSaveCandidateHistory() {
        $candidateHistory = new CandidateHistory();
        $candidateHistory->candidateVacancyId = 2;
        $candidateHistory->candidateId = 1;
        $candidateHistory->action = 2;
        $candidateHistory->performedBy = null;
        $candidateHistory->performedDate = '2011-04-05';
        $candidateHistory->note = 'dvfsdfds';
        $result = $this->candidateDao->SaveCandidateHistory($candidateHistory);
        $this->assertTrue($result);
    }

    public function testUpdateCandidate() {
        $candidate = new JobCandidate();
        $candidate->id = 3;
        $candidate->firstName = "editedFirstName";
        $candidate->lastName = "editedLastName";
        $candidate->contactNumber = "0715446756";
        $candidate->keywords = "java,c,c++";
        $candidate->email = "test@gmail.com";
        $candidate->dateOfApplication = "2011-03-05";
        $candidate->middleName = "editedMiddleName";
        $candidate->comment = "updated Comment";
        $result = $this->candidateDao->updateCandidate($candidate);
        $this->assertEquals($result, 1);
    }

    public function testGetCandidateHistoryForCandidateId() {
	$allowedHistoryList = array(1,2);
        $result = $this->candidateDao->getCandidateHistoryForCandidateId(1,$allowedHistoryList);
        $this->assertTrue($result[0] instanceof CandidateHistory);
        $this->assertEquals($result[0]->getAction(), 1);
    }

    public function testGetCandidateHistoryById() {
        $result = $this->candidateDao->getCandidateHistoryById(1);
        $this->assertTrue($result instanceof CandidateHistory);
    }

    public function testGetAllVacancyIdsForCandidate() {

        $result = $this->candidateDao->getAllVacancyIdsForCandidate(1);
        $this->assertEquals(2, count($result));

        $this->assertEquals(array(1, 3), $result);

        $result = $this->candidateDao->getAllVacancyIdsForCandidate(3);
        $this->assertEquals(3, count($result));
        $this->assertEquals(array(1, 2, 3), $result);

        $result = $this->candidateDao->getAllVacancyIdsForCandidate(10);
        $this->assertEquals(0, count($result));
    }

    public function testDeleteCandidatesTestTrue() {

        $candidatesId = array(1, 3);
        $result = $this->candidateDao->deleteCandidates($candidatesId);
        $this->assertEquals(true, $result);

        $candidatesId = array(2, 3);
        $result = $this->candidateDao->deleteCandidates($candidatesId);
        $this->assertEquals(true, $result);
    }

    public function testDeleteCandidatesTestFalse() {

        $candidatesId = array(100, 107, 123);
        $result = $this->candidateDao->deleteCandidates($candidatesId);
        $this->assertEquals(false, $result);

        $candidatesId = array(100, 101, 102);
        $result = $this->candidateDao->deleteCandidates($candidatesId);
        $this->assertEquals(false, $result);
    }

    public function testDeleteCandidateVacancies() {

        $toBeDeletedRecords = array(array(2, 3), array(1, 3), array(3, 3));
        $result = $this->candidateDao->deleteCandidateVacancies($toBeDeletedRecords);
        $this->assertEquals(true, $result);

        $toBeDeletedRecords = array(array(1, 2), array(6, 4));
        $result = $this->candidateDao->deleteCandidateVacancies($toBeDeletedRecords);
        $this->assertEquals(false, $result);
    }

//    public function testSaveCandidateHistoryTest() {
//
//        $candidateHistory = new CandidateHistory();
//        $candidateHistory->candidateVacancyId = 2;
//        $candidateHistory->candidateId = 1;
//        $candidateHistory->action = 2;
//        $candidateHistory->performedBy = null;
//        $candidateHistory->performedDate = '2011-04-05';
//        $candidateHistory->note = 'dvfsdfds';
//
//        $newJobInterview = new JobInterview();
//
//        $newJobInterview->setInterviewName("HR Interview");
//        $newJobInterview->setInterviewDate("2011-04-03");
//        $newJobInterview->setInterviewTime("08:48");
//        $newJobInterview->setNote("new note");
//        $candidateHistory->setJobInterview($newJobInterview);
//        $result = $this->candidateDao->SaveCandidateHistory($candidateHistory);
//        $this->assertTrue($result);
//    }
//
//    public function testSaveCandidateHistoryTestAgain() {
//
//        $candidateHistory = new CandidateHistory();
//        $candidateHistory->candidateVacancyId = 2;
//        $candidateHistory->candidateId = 1;
//        $candidateHistory->action = 2;
//        $candidateHistory->performedBy = null;
//        $candidateHistory->performedDate = '2011-04-05';
//        $candidateHistory->note = 'dvfsdfds';
//
//        $newJobInterview = new JobInterview();
//
//        $newJobInterview->setInterviewName("HR Interview");
//        $newJobInterview->setInterviewDate("2011-04-03");
//        $newJobInterview->setInterviewTime("08:48");
//        $newJobInterview->setNote("new note");
//
//        $newJobInterviewInterviewer = new JobInterviewInterviewer();
//        $newJobInterviewInterviewer->setInterviewerId(5);
//
//        $newJobInterviewInterviewer1 = clone $newJobInterviewInterviewer;
//        $newJobInterviewInterviewer1->setInterviewerId(2);
//
//        $newJobInterview->getJobInterviewInterviewer()->add($newJobInterviewInterviewer);
//        $newJobInterview->getJobInterviewInterviewer()->add($newJobInterviewInterviewer1);
//        $candidateHistory->setJobInterview($newJobInterview);
//        $result = $this->candidateDao->SaveCandidateHistory($candidateHistory);
//        $this->assertTrue($result);
//    }

    public function testSaveJobInterview() {

        $newJobInterview = new JobInterview();

        $newJobInterview->setInterviewName("HR Interview");
        $newJobInterview->setInterviewDate("2011-04-03");
        $newJobInterview->setInterviewTime("08:48");
        $newJobInterview->setNote("new note");
        $newJobInterview->setCandidateVacancyId(2);

        $newJobInterviewInterviewer = new JobInterviewInterviewer();
        $newJobInterviewInterviewer->setInterviewerId(5);

        $newJobInterviewInterviewer1 = clone $newJobInterviewInterviewer;
        $newJobInterviewInterviewer1->setInterviewerId(2);

        $newJobInterview->getJobInterviewInterviewer()->add($newJobInterviewInterviewer);
        $newJobInterview->getJobInterviewInterviewer()->add($newJobInterviewInterviewer1);
        $this->assertEquals(null, $newJobInterview->save());
    }

    public function testGetCandidateListForHiringManagerRole() {
        $candidatesForHiringManager = $this->candidateDao->getCandidateListForUserRole(HiringManagerUserRoleDecorator::HIRING_MANAGER, 2);
        $this->assertEquals(count($candidatesForHiringManager), 3);
    }

    public function testGetCandidateListForInterviewerRole() {
        $candidatesForInterviewer = $this->candidateDao->getCandidateListForUserRole(InterviewerUserRoleDecorator::INTERVIEWER, 3);
        $this->assertEquals(count($candidatesForInterviewer), 1);
    }

    public function testGetCandidateListForAdminRole() {
        $candidatesForAdmin = $this->candidateDao->getCandidateListForUserRole(AdminUserRoleDecorator::ADMIN_USER, null);
        $this->assertEquals(count($candidatesForAdmin), 5);
    }

    public function testGetCandidateHistoryForHiringManagerRole() {
        $candidatesHistoryForHM = $this->candidateDao->getCanidateHistoryForUserRole(HiringManagerUserRoleDecorator::HIRING_MANAGER, 3, 1);
        $this->assertEquals(count($candidatesHistoryForHM), 1);
    }

    public function testGetCandidateHistoryForInterviewerRole() {
        $candidatesHistoryForInterviewer = $this->candidateDao->getCanidateHistoryForUserRole(InterviewerUserRoleDecorator::INTERVIEWER, 3, 1);
        $this->assertEquals(count($candidatesHistoryForInterviewer), 2);
    }

    public function testGetCandidateHistoryForAdminRole() {
        $candidatesHistoryForAdmin = $this->candidateDao->getCanidateHistoryForUserRole(AdminUserRoleDecorator::ADMIN_USER, null, 1);
        $this->assertEquals(count($candidatesHistoryForAdmin), 2);
    }

}

