<?php
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

namespace OrangeHRM\Time\Report;

use OrangeHRM\Core\Api\V2\Validator\ParamRuleCollection;
use OrangeHRM\Core\Dto\FilterParams;
use OrangeHRM\Core\Report\Api\EndpointAwareReport;
use OrangeHRM\Core\Report\Api\EndpointProxy;
use OrangeHRM\Core\Report\Filter\FilterDefinition;
use OrangeHRM\Core\Report\Header\HeaderDefinition;
use OrangeHRM\Core\Report\ReportData;

class ProjectReport implements EndpointAwareReport
{
    /**
     * @inheritDoc
     */
    public function prepareFilterParams(EndpointProxy $endpoint): FilterParams
    {
        // TODO: Implement prepareFilterParams() method.
    }

    /**
     * @inheritDoc
     */
    public function getValidationRule(EndpointProxy $endpoint): ParamRuleCollection
    {
        // TODO: Implement getValidationRule() method.
    }

    /**
     * @inheritDoc
     */
    public function checkReportAccessibility(EndpointProxy $endpoint): void
    {
        // TODO: Implement checkReportAccessibility() method.
    }

    /**
     * @inheritDoc
     */
    public function getHeaderDefinition(): HeaderDefinition
    {
        // TODO: Implement getHeaderDefinition() method.
    }

    /**
     * @inheritDoc
     */
    public function getFilterDefinition(): FilterDefinition
    {
        // TODO: Implement getFilterDefinition() method.
    }

    /**
     * @inheritDoc
     */
    public function getData(FilterParams $filterParams): ReportData
    {
        // TODO: Implement getData() method.
    }
}
