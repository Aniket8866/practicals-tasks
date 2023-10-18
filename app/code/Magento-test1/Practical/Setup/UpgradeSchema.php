<?php
namespace Magento360\Practical\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Quote\Setup\QuoteSetup;
use Magento\Sales\Setup\SalesSetup;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $quoteTable = 'quote';
        //Quote table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'additional_name',
                [
                    'type'     => Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment'  => 'Additional Name'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'additional_number',
                [
                    'type'     => Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment'  => 'Additional phone number'
                ]
            );
       
        $setup->endSetup();
    }
}
