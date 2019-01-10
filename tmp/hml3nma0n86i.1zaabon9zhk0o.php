<h3 class="text-primary"><?= ($cat) ?> <a href="#" class="badge badge-pill badge-secondary title" data-toggle="collapse" data-target="#setsHelp" aria-expanded="false" aria-controls="setsHelp">
	?</a>
	</a></h3>
<div class="collapse" id="setsHelp">
	<div class="card card-body">
		<dt>From SimsLegacyChallenge.com</dt>
		<dd>1 point per Alien pregnancy<br/>
			It does not matter if the pregnancy results in twins or not, it’s still 1 point.
			<br/><br/>
			1 point for each complete set of platinum graves.<br/>
			A ‘set’ is 1 of each of the 7 different aspirations.<br/>
			If you do not own Nightlife, a ‘set’ is 1 of each of the 5 different aspirations
			<br/><br/>
			1 point for getting all 25 career reward objects<br/>
			This point may only be earned once<br/>
			If you do not own one of the expansion packs that add new jobs, you do not need to count those jobs.
			<br/><br/>
			1 point per 25 bottles of unused elixier of life<br/>
			Once you amass 25 bottles, you can delete them all, score 1 point and begin again.<br/>
			The easiest way to keep track is to mark off a 5X5 area. Once the area is filled with bottles you know you have 25 and have earned 1 point.<br/>
			Bottles that have been used even once may not count in the 25.
			<br/><br/>
			2 points if each impossible want is fulfilled at least once.<br/>
			There are 12 different impossible wants. If you can fulfill each different one at least once, you earn this bonus. Impossible wants must be fulfilled by a sim of the proper aspiration, but a single sim may fulfill more than one for the purposes of this bonus.
			<br/><br/>
			<h6 class="text-primary">Free Time Updates</h6>
			1 point for having a complete bug collection
			<br/><br/>
			1 point for having a complete set of awards for hobbies.
			<br/><br/>
			Points over 10 in this category go into overflow.
		</dd>
	</div>
</div>
<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="alienpreg">Alien Pregnancies</label>
            <input type="number" min="0" class="form-control sets" id="alienpreg" value="<?= (trim($s2legacy['alienpreg'])) ?>" name="alienpreg"/>
        </div>
        <div class="form-group">
            <label for="platgraves">Platinum Grave Sets</label>
            <input type="number" min="0" class="form-control sets" id="platgraves" value="<?= (trim($s2legacy['platgraves'])) ?>" name="platgraves"/>
        </div>
        <div class="form-group">
            <label for="elixirs">Sets of 25 Unused Elixirs</label>
            <input type="number" min="0" class="form-control sets" id="elixirs" value="<?= (trim($s2legacy['elixirs'])) ?>" name="elixirs"/>
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input sets" value="1" name="allwants" id="allwants"
				<?php if ($s2legacy['allwants'] == 1): ?>
					checked
				<?php endif; ?>
				/>
                <label class="custom-control-label" for="allwants">All Impossible Wants</label>
            </div>
            <div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input sets" value="1" name="allbugs" id="allbugs"
				<?php if ($s2legacy['allbugs'] == 1): ?>
					checked
				<?php endif; ?>
				/>
                <label class="custom-control-label" for="allbugs">Complete Bug Collection <img src="<?= ($BASE) ?><?= ($s2path) ?>FT.png" alt="Needs FT"></label>
            </div>
            <div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input sets" value="1" name="allhobbies" id="allhobbies"
				<?php if ($s2legacy['allhobbies'] == 1): ?>
					checked
				<?php endif; ?>
				/>
                <label class="custom-control-label" for="allhobbies">Complete Set of Hobby Awards <img src="<?= ($BASE) ?><?= ($s2path) ?>FT.png" alt="Needs FT"></label>
            </div>
            <div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input sets" value="1" name="allcareers" id="allcareers"
				<?php if ($s2legacy['allcareers'] == 1): ?>
					checked
				<?php endif; ?>
				/>
                <label class="custom-control-label" for="allcareers">Complete Set of Career Rewards</label>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="setstotal" id="ct" value="<?= (trim($s2legacy['setstotal'])) ?>">
<p class="lead"><b>Sub total: <output id="setstotal" for="ct"><span
    <?php if ($s2legacy['setstotal']  == 0): ?>class="badge badge-primary"<?php endif; ?>
    <?php if ($s2legacy['setstotal']  > 0): ?>class="badge badge-success"<?php endif; ?>
    <?php if ($s2legacy['setstotal']  < 0): ?>class="badge badge-danger"<?php endif; ?>>
    <?= (trim($s2legacy['setstotal']))."
" ?>
    </span></b></p>

<script>
	$(function () {
		setsboxes();
		$(".sets").change(function(){
			setsboxes();
		});
	});

	function setsboxes() {
		let boxes = $('.sets:checked').length;
		if ($('#allwants').prop('checked'))
			boxes ++;
		let ap = $("#alienpreg").val();
		let pg = $("#platgraves").val();
		let ex = $("#elixirs").val();
		setsSub(boxes, ap, pg, ex);
	}

	function setsSub(boxes, ap, pg, ex) {
		let result = parseFloat(ap) + parseFloat(pg) + parseFloat(ex) + parseFloat(boxes);
		if (result > 10) {
			let o = result - 10;
			result = 10;
			$("#osets").val(o);
			osetsChange(o);
		} else {
			$("#osets").val(0);
			osetsChange(0);
		}
		$("#setstotal").val(result);
		$("#ct").val(result);
		gtChange();

		if (result == 0) {
			$('#setstotal').removeClass('badge badge-danger');
			$('#setstotal').removeClass('badge badge-success');
			$('#setstotal').addClass('badge badge-primary');
		}


		if (result > 0) {
			$('#setstotal').removeClass('badge badge-danger');
			$('#setstotal').removeClass('badge badge-primary');
			$('#setstotal').addClass('badge badge-success');
		}

		if (result < 0) {
			$('#setstotal').removeClass('badge badge-primary');
			$('#setstotal').removeClass('badge badge-success');
			$('#setstotal').addClass('badge badge-danger');
		}
	}
</script>
