<?php

/**
 * Class ModalWindow
 */
class ModalWindow {

    /**
     * @var string
     */
    private $buttonText;
    /**
     * @var string
     */
    private $targetText;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $bodyText;
    /**
     * @var string
     */
    private $getId;
    /**
     * @var string
     */
    private $modalButtonText;

    /**
     * ModalWindow constructor.
     * @param $buttonText
     * @param $targetText
     * @param $title
     * @param $bodyText
     * @param $getId
     * @param $modalButtonText
     */
    public function __construct($buttonText, $targetText, $title, $bodyText, $getId, $modalButtonText)
    {
        $this->buttonText = $buttonText;
        $this->targetText = $targetText;
        $this->title = $title;
        $this->bodyText = $bodyText;
        $this->getId = $getId;
        $this->modalButtonText = $modalButtonText;
    }

    /**
     *
     */
    public function echoModalWindow($size = "") {
        ?>
        <div class="modal fade" id="<?=$this->targetText?>" tabindex="-1" role="dialog"
             aria-labelledby="<?=$this->targetText?>Label" aria-hidden="true">
            <div class="modal-dialog <?=$size?>" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="<?=$this->targetText?>Label"><?=$this->title?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?=$this->bodyText?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-lg imemo-button text-uppercase"
                                data-dismiss="modal">Закрыть
                        </button>
                        <?php if(!empty($this->modalButtonText)):?>
                        <button type="button" class="btn btn-lg imemo-button text-uppercase"
                                id="<?=$this->targetText?>Button" data-dismiss="modal" data-<?=$this->getId?>="#"><?=$this->modalButtonText?>
                        </button>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <script>

            $("#<?=$this->targetText?>Button").on("click", function (event) {
                event.preventDefault();
                jQuery.ajax({
                    type: 'GET',
                    data: { <?=$this->getId?>: $(this).data('<?=$this->getId?>')},
                    complete: function () {
                        location.reload();
                    }
                })
            });
            $('#<?=$this->targetText?>').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('<?=$this->getId?>');
                var modal = $(this);
                modal.find('#<?=$this->targetText?>Button').attr('data-<?=$this->getId?>', id);
                modal.find('#<?=$this->targetText?>Button').data('<?=$this->getId?>', id);
            });

        </script>
        <?php
    }

    /**
     *
     */
    public function echoButton($data, $class) {
        ?>
        <button type="button"
                class="<?=$class?> border-0 m-0 p-0 focus-0"
                style="background: none" data-toggle="modal"
                data-target="#<?=$this->targetText?>"
                data-<?=$this->getId?>="<?=$data?>">
            <?=$this->buttonText?>
        </button>
        <?php
    }

}