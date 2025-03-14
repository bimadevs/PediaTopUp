                        <div class="col-12 mt-2 px-6">
                            <label style="font-size: 13px;">Detail withdraw: </label>
                            <div class="boxtime d-block mx-auto w-100 mt-3 p-3 shadow-sm rounded">
                                <strong>Total Withdraw</strong>
                                <div class="detail-deposit d-block mx-auto mt-2 text-success font-weight-bold"><?= $curr . " " .number_format($withdraws['total'], 0, ",", "."); ?></div>
                            </div>
                        </div>
                        
                        <?php if(isset($withdraws['bonus']) && $withdraws['bonus'] > 0) : ?>
                        <div class="col-12 mt-3 px-6">
                            <label style="font-size: 13px;">Saldo yang kamu dapat: </label>
                            <div class="boxtime d-block mx-auto w-100 mt-3 p-3 shadow-sm rounded">
                                <strong>Total Saldo</strong> <small>*Saldo yang kamu dapat</small>
                                <div class="detail-deposit d-block mx-auto mt-2 text-success font-weight-bold"><?= $curr . " " .number_format($withdraws['total']+$withdraws['bonus'], 0, ",", "."); ?></div>
                            </div>
                        </div>
                        <?php endif ?>
                    <?php if($withdraws['status'] == "pending") : ?>
                        <div class="col-12 mt-2 px-6">
                            <label style="font-size: 13px;">Detail withdraw: </label>
                            <div class="boxtime d-block mx-auto w-100 mt-3 p-3 shadow-sm rounded">
                                <strong>Total Penarikan</strong>
                                <div class="detail-deposit d-block mx-auto mt-2 font-weight-bold" style="color: #00AA5B !important;"><?= $curr . " " .number_format($withdraws['total'], 0, ",", "."); ?></div>
                            </div>
                        </div>
                        
                        <?php if(isset($withdraws['bonus']) && $withdraws['bonus'] > 0) : ?>
                        <div class="col-12 mt-3 px-6">
                            <label style="font-size: 13px;">Saldo yang kamu dapat: </label>
                            <div class="boxtime d-block mx-auto w-100 mt-3 p-3 shadow-sm rounded">
                                <strong>Total Saldo</strong> <small>*Saldo yang kamu dapat</small>
                                <div class="detail-deposit d-block mx-auto mt-2 font-weight-bold" style="color: #00AA5B !important;"><?= $curr . " " .number_format($withdraws['total']+$withdraws['bonus'], 0, ",", "."); ?></div>
                            </div>
                        </div>
                        <?php endif ?>
                    <?php elseif($withdraws['status'] == "approved") : ?>
                        <div class="col-12" style="padding: 0 30px;">
                            <span class="css-c1gsx8">Total Penarikan</span>
                            <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px; color: #00AA5B !important;"><?= $curr . " " .number_format($withdraws['total'], 0, ",", "."); ?></p>
                        </div>
                    <?php elseif($withdraws['status'] == "declined") : ?>
                        <div class="col-12" style="padding: 0 30px;">
                            <span class="css-c1gsx8">Total Penarikan</span>
                            <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px; color: #00AA5B !important;"><?= $curr . " " .number_format($withdraws['total'], 0, ",", "."); ?></p>
                        </div>
                    <?php endif ?>
                    
                    <div class="col-12" style="padding: 0 30px;">
                        <span class="css-c1gsx8">Total Pembayaran</span>
                        <p class="font-weight-bold" style="margin-top: -5px; font-size: 12px; color: #00AA5B !important;"><?= $curr . " " .number_format($withdraws['total']+$withdraws['uniq'], 0, ",", "."); ?></p>
                    </div> 