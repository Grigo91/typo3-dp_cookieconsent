<?php
/*
 * Copyright (c) 2021.
 *
 * @category   TYPO3
 *
 * @copyright  2021 Dirk Persky (https://github.com/DirkPersky)
 * @author     Dirk Persky <info@dp-wired.de>
 * @license    MIT
 */

namespace DirkPersky\DpCookieconsent\Controller;

use ArrayObject;
use DirkPersky\DpCookieconsent\Domain\Repository\CookieRepository;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class CookieController extends ActionController
{

    /**
     * @var CookieRepository
     */
    protected $cookieRepository;

    /**
     * @param CookieRepository
     */
    public function injectCookieRepository(CookieRepository $cookieRepository)
    {
        $this->cookieRepository = $cookieRepository;
    }

    /**
     * @return void
     */
    public function listAction()
    {
        $cObj = $this->configurationManager->getContentObject();
        // parse Flexform
        $flexFormData = GeneralUtility::makeInstance(FlexFormService::class)->convertFlexFormContentToArray($cObj->data['pi_flexform']);
        // get Cookies
        $cookies = $this->cookieRepository->findByPid($flexFormData['settings']['startingpoint'], $flexFormData['settings']['recursive']);
        // group cookies
        $grouped = new ArrayObject([]);
        foreach ($cookies as $cookie) {
            $category = $cookie->getCategory();
            if (!isset($grouped[$category])) {
                $grouped[$category] = new ArrayObject([
                    'category' => $category,
                    'items' => new ArrayObject([])
                ]);
            }
            $grouped[$category]['items'][] = $cookie;
        }

        // update settings
        $this->settings['base_uri'] = parse_url($this->request->getBaseUri());
        $this->view->assign('settings', $this->settings);
        // add data to view
        $this->view->assign('data', $cObj->data);
        $this->view->assign('cookies', $cookies);
        $this->view->assign('grouped', $grouped);
    }
}
