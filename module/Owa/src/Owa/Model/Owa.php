<?php

namespace Owa\Model;

use PhpEws\DataType\ConnectingSIDType;
use PhpEws\DataType\ConstantValueType;
use PhpEws\DataType\DefaultShapeNamesType;
use PhpEws\DataType\DistinguishedFolderIdNameType;
use PhpEws\DataType\DistinguishedFolderIdType;
use PhpEws\DataType\ExchangeImpersonationType;
use PhpEws\DataType\FieldURIOrConstantType;
use PhpEws\DataType\FindItemResponseMessageType;
use PhpEws\DataType\FindItemType;
use PhpEws\DataType\IndexedPageViewType;
use PhpEws\DataType\IsEqualToType;
use PhpEws\DataType\ItemQueryTraversalType;
use PhpEws\DataType\ItemResponseShapeType;
use PhpEws\DataType\NonEmptyArrayOfBaseFolderIdsType;
use PhpEws\DataType\PathToUnindexedFieldType;
use PhpEws\DataType\RestrictionType;
use PhpEws\EwsConnection;

/**
 * Description of Owa
 *
 * @author fandria
 */
class Owa {
    
    /* @var $ews EwsConnection */
    protected $ews;
    
    public function __construct($ews) {
        $this->ews = $ews;
    }
    
    public function setImpersonation($mail) {
        // Configure impersonation
        $ews = $this->ews;
        $ei = new ExchangeImpersonationType();
        $sid = new ConnectingSIDType();
        $sid->PrimarySmtpAddress = $mail;
        $ei->ConnectingSID = $sid;
        $ews->setImpersonation($ei);
    }
    
    public function getUnreadMails() {
        
        $request = new FindItemType();
        $itemProperties = new ItemResponseShapeType();
        $itemProperties->BaseShape = DefaultShapeNamesType::ID_ONLY;
        $request->ItemShape = $itemProperties;

        $request->IndexedPageItemView = new IndexedPageViewType();
        $request->IndexedPageItemView->BasePoint = 'Beginning';

        $request->IndexedPageItemView->Offset = 0;

        $fieldType = new PathToUnindexedFieldType();
        $fieldType->FieldURI = 'message:IsRead';

        $constant = new FieldURIOrConstantType();
        $constant->Constant = new ConstantValueType();
        $constant->Constant->Value = "0";

        $IsEqTo = new IsEqualToType();
        $IsEqTo->FieldURIOrConstant = $constant;
        $IsEqTo->Path = $fieldType;

        $request->Restriction = new RestrictionType();
        $request->Restriction->IsEqualTo = new IsEqualToType();
        $request->Restriction->IsEqualTo->FieldURI = $fieldType;
        $request->Restriction->IsEqualTo->FieldURIOrConstant = $constant;

        $request->IndexedPageItemView = new IndexedPageViewType();
        $request->IndexedPageItemView->BasePoint = 'Beginning';
        $request->IndexedPageItemView->Offset = 0;

        $request->ParentFolderIds = new NonEmptyArrayOfBaseFolderIdsType();
        $request->ParentFolderIds->DistinguishedFolderId = new DistinguishedFolderIdType();
        $request->ParentFolderIds->DistinguishedFolderId->Id = DistinguishedFolderIdNameType::INBOX;

        $request->Traversal = ItemQueryTraversalType::SHALLOW;

        $response = new FindItemResponseMessageType();
        if ($this->ews) {
            $response = $this->ews->FindItem($request);

            return $response;
        } else {
            return null;
        }
    }
    
    public function getNumberOfUnread($response) {
        $numberOfUnreadMail = 0;

        if (isset($response->ResponseMessages->FindItemResponseMessage->RootFolder->TotalItemsInView)) {
            $numberOfUnreadMail = $response->ResponseMessages->FindItemResponseMessage->RootFolder->TotalItemsInView;
        }

        return $numberOfUnreadMail;
    }
    
    
}
