<?php

namespace App\Http\Resources\Public;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request, ...$mode)
    {
        return [
            //basic
            'id' => $this->{Product::COL_ID},
            'name' => $this->{Product::COL_NAME},
            'price' => $this->{Product::COL_PRICE},
            'salePrice' => $this->when($this->{Product::COL_SALE}, function () {
                $saleRepository = new SaleRepository();
                return $saleRepository->getSalePrice($this->{Product::COL_ID});
            }),
            'avt' => $this->when($this->{Product::COL_AVT}, function () {
                $imageRepository = new ImageRepository();
                $image = $imageRepository->getImageModel($this->{Product::COL_AVT});
                return $image->{Image::COL_LINK};
            }),
            'status' => $this->{Product::COL_STATUS},
            'categoryId' => $this->{Product::COL_CATEGORY},
            'category' => $this->category->{Category::COL_NAME},

            //detail
            $this->mergeWhen($this->detail, [
                'desc' => $this->{Product::COL_DESC},
                'images' => ImageResource::collection($this->images),
                'sizes' => $this->getProductAmount($this->sizes),
            ]),

            //admin
            $this->mergeWhen($request->user() ? $request->user()->tokenCan('admin') : null, [
                'cost' => $this->{Product::COL_COST},
                'sold' => $this->{Product::COL_SOLD},
                'total' => app((ProductRepository::class))->getQuantityTotal($this->{Product::COL_ID}),
            ]),

            'total' => $this->when($this->total, $this->total),
            'pageSize' => $this->when($this->per_page, $this->per_page),
        ];
    }

    private function shouldDetail($request)
    {
        // return $request->route()->getName() === 'products.show'||$request->user()->;
    }

    private function getProductAmount($data)
    {
        $response = [];
        if (is_countable($data)) {
            foreach ($data as $item) {
                $response[] = [
                    'id' => $item->{Size::COL_ID},
                    'name' => $item->{Size::COL_NAME},
                    'quantity' => $item->pivot->quantity,
                ];
            }
        } else {
            $response[] = [
                'id' => $data->{Size::COL_ID},
                'name' => $data->{Size::COL_NAME},
                'quantity' => $data->pivot->quantity,
            ];
        }
        return $response;
    }
}
