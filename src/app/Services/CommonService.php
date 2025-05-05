<?php

namespace App\Services;

use App\Models\stocks;

class CommonService
{
    /**
     * Обновляет остатки товаров на складе
     *
     * @param array $prouctsArray Массив товаров с ключами product_id и count
     * @param int $warehouse_id ID склада
     * @param bool $plus Флаг увеличения (true) или уменьшения (false) остатков
     * @return void
     *
     * @throws \Exception Если товара нет на складе или недостаточно остатков при уменьшении
     *
     */

    public function updateStocks(array $prouctsArray, int $warehouse_id, bool $plus=true)
    {
        $err =[];
        foreach ($prouctsArray as $itemData) {
            $stoks = stocks::where('warehouse_id', $warehouse_id)
                ->where('product_id', $itemData['product_id'])
                ->first();
            if ($stoks) {
                if ($plus){
                    $stoks->stock += $itemData['count'];
                }
                else{
                    if ($stoks->stock < $itemData['count']) {
                        $err[] = $this->createError(400,'Товара не хватает на складе');
                        continue;
                    }
                    $stoks->stock -= $itemData['count'];
                }
                $stoks->save();
            }else {
                $err[] = $this->createError(400,'Товара не найден на складе: ' . $itemData['product_id']);
            }
        }
        if (!empty($err))
        {
            echo print_r($err,1);
            die();
        }
    }
    /**
     * Создает строку с сообщением об ошибке в формате "[error #код] сообщение"
     *
     * @param string $code Код ошибки
     * @param string $message Текст сообщения об ошибке
     * @return string Отформатированная строка с ошибкой
     */
    public function createError(
        string $code,
        string $message,
    ): string {

        $errorMessage = "[error #{$code}] {$message}";
        return $errorMessage;
    }
}
